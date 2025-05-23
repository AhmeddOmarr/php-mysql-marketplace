<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../config/jwt.php';

$database = new Database();
$db = $database->getConnection();
$jwt = new JWTHandler();

// Get headers
$headers = getallheaders();
$token = isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : null;

if (!$token || !($user = $jwt->validateToken($token))) {
    http_response_code(401);
    echo json_encode(["status" => false, "message" => "Unauthorized"]);
    exit();
}

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {
    case 'GET':
        // Get cart items
        $query = "SELECT c.*, p.name, p.price, p.image 
                 FROM cart c 
                 JOIN products p ON c.product_id = p.id 
                 WHERE c.user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user->user_id);
        $stmt->execute();
        
        $items = [];
        $total = 0;
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = [
                "id" => $row['id'],
                "product_id" => $row['product_id'],
                "name" => $row['name'],
                "price" => $row['price'],
                "quantity" => $row['quantity'],
                "image" => $row['image'],
                "subtotal" => $row['price'] * $row['quantity']
            ];
            $total += $item['subtotal'];
            array_push($items, $item);
        }
        
        echo json_encode([
            "status" => true,
            "data" => [
                "items" => $items,
                "total" => $total
            ]
        ]);
        break;

    case 'POST':
        // Add to cart
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->product_id) && !empty($data->quantity)) {
            // Check if product exists in cart
            $checkQuery = "SELECT id, quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id";
            $checkStmt = $db->prepare($checkQuery);
            $checkStmt->bindParam(':user_id', $user->user_id);
            $checkStmt->bindParam(':product_id', $data->product_id);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                // Update quantity
                $cart = $checkStmt->fetch(PDO::FETCH_ASSOC);
                $newQuantity = $cart['quantity'] + $data->quantity;
                
                $query = "UPDATE cart SET quantity = :quantity WHERE id = :id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':quantity', $newQuantity);
                $stmt->bindParam(':id', $cart['id']);
            } else {
                // Insert new item
                $query = "INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':user_id', $user->user_id);
                $stmt->bindParam(':product_id', $data->product_id);
                $stmt->bindParam(':quantity', $data->quantity);
            }
            
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Product added to cart successfully"
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    "status" => false,
                    "message" => "Unable to add product to cart"
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "Product ID and quantity are required"
            ]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        
        if (!empty($data->cart_id)) {
            $query = "DELETE FROM cart WHERE id = :cart_id AND user_id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':cart_id', $data->cart_id);
            $stmt->bindParam(':user_id', $user->user_id);
            
            if ($stmt->execute()) {
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Item removed from cart successfully"
                ]);
            } else {
                http_response_code(503);
                echo json_encode([
                    "status" => false,
                    "message" => "Unable to remove item from cart"
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => false,
                "message" => "Cart item ID is required"
            ]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode([
            "status" => false,
            "message" => "Method not allowed"
        ]);
        break;
} 