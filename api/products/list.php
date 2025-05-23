<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

// Get query parameters
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$category = isset($_GET['category']) ? $_GET['category'] : null;
$search = isset($_GET['search']) ? $_GET['search'] : null;

$offset = ($page - 1) * $limit;

// Base query
$query = "SELECT p.*, c.name as category_name, u.username as seller_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          LEFT JOIN users u ON p.seller_id = u.id 
          WHERE 1=1";

// Add filters
if ($category) {
    $query .= " AND p.category_id = :category";
}
if ($search) {
    $query .= " AND (p.name LIKE :search OR p.description LIKE :search)";
}

// Add pagination
$query .= " LIMIT :limit OFFSET :offset";

$stmt = $db->prepare($query);
$stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

if ($category) {
    $stmt->bindParam(':category', $category);
}
if ($search) {
    $search = "%$search%";
    $stmt->bindParam(':search', $search);
}

$stmt->execute();

$products = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    // Format product data
    $product = [
        "id" => $row['id'],
        "name" => $row['name'],
        "description" => $row['description'],
        "price" => $row['price'],
        "image" => $row['image'],
        "category" => [
            "id" => $row['category_id'],
            "name" => $row['category_name']
        ],
        "seller" => [
            "id" => $row['seller_id'],
            "name" => $row['seller_name']
        ]
    ];
    array_push($products, $product);
}

// Get total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM products WHERE 1=1";
if ($category) {
    $countQuery .= " AND category_id = :category";
}
if ($search) {
    $countQuery .= " AND (name LIKE :search OR description LIKE :search)";
}

$countStmt = $db->prepare($countQuery);
if ($category) {
    $countStmt->bindParam(':category', $category);
}
if ($search) {
    $countStmt->bindParam(':search', $search);
}
$countStmt->execute();
$totalCount = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

http_response_code(200);
echo json_encode([
    "status" => true,
    "data" => [
        "products" => $products,
        "pagination" => [
            "page" => $page,
            "limit" => $limit,
            "total" => (int)$totalCount,
            "total_pages" => ceil($totalCount / $limit)
        ]
    ]
]); 