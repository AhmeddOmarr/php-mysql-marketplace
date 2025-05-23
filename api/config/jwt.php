<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTHandler {
    private $jwt_secret = "secure_marketplace_jwt_secret_2024";  // Updated secure key
    private $token_duration = 24 * 3600; // 24 hours

    public function generateToken($user_id, $email, $role) {
        $issuedAt = time();
        $expire = $issuedAt + $this->token_duration;

        $data = [
            'iat'  => $issuedAt,
            'exp'  => $expire,
            'data' => [
                'user_id' => $user_id,
                'email' => $email,
                'role' => $role
            ]
        ];

        return JWT::encode($data, $this->jwt_secret, 'HS256');
    }

    public function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->jwt_secret, 'HS256'));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }
} 