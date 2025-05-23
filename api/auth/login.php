<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once '../config/database.php';
include_once '../config/jwt.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$db = $database->getConnection();
$jwt = new JWTHandler();

// Get posted data
$data = json_decode(file_get_contents("php://input"));

// Log incoming request
error_log("Login attempt for email: " . ($data->email ?? 'not provided'));

if (!empty($data->email) && !empty($data->password)) {
    try {
        $query = "SELECT id, email, password, role FROM users WHERE email = ? LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bindParam(1, $data->email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (password_verify($data->password, $row['password'])) {
                $token = $jwt->generateToken($row['id'], $row['email'], $row['role']);
                
                http_response_code(200);
                echo json_encode([
                    "status" => true,
                    "message" => "Login successful",
                    "token" => $token,
                    "user" => [
                        "id" => $row['id'],
                        "email" => $row['email'],
                        "role" => $row['role']
                    ]
                ]);
                error_log("Login successful for user: " . $row['email']);
            } else {
                http_response_code(401);
                echo json_encode([
                    "status" => false,
                    "message" => "Invalid password"
                ]);
                error_log("Invalid password for user: " . $data->email);
            }
        } else {
            http_response_code(401);
            echo json_encode([
                "status" => false,
                "message" => "User not found"
            ]);
            error_log("User not found: " . $data->email);
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode([
            "status" => false,
            "message" => "Database error occurred",
            "error" => $e->getMessage()
        ]);
        error_log("Database error: " . $e->getMessage());
    }
} else {
    http_response_code(400);
    echo json_encode([
        "status" => false,
        "message" => "Email and password are required"
    ]);
    error_log("Missing email or password in request");
} 