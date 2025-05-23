<?php
session_start();
require_once 'config.php';

// Initialize database connection
$query = new Database();

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Check if there's a pending transaction
if (!isset($_SESSION['pending_transaction_id'])) {
    header('Location: index.php');
    exit();
}

$transaction_id = $_SESSION['pending_transaction_id'];
$user_id = $_SESSION['id'];

// Get transaction details
$transaction = $query->executeQuery("SELECT t.*, p.name as product_name 
                                   FROM transactions t 
                                   JOIN products p ON t.product_id = p.id 
                                   WHERE t.id = $transaction_id AND t.user_id = $user_id")->fetch_assoc();

if (!$transaction) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/style.css">
    <style>
        .success-container {
            max-width: 600px;
            margin: 4rem auto;
            padding: 2rem;
            text-align: center;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .success-icon {
            color: #28a745;
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .transaction-details {
            margin: 2rem 0;
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 8px;
            text-align: left;
        }
        .transaction-details p {
            margin: 0.5rem 0;
        }
        .btn-container {
            margin-top: 2rem;
        }
        .btn-container a {
            margin: 0 0.5rem;
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Payment Successful!</h2>
            <p class="lead">Your transaction has been submitted and is waiting for admin approval.</p>
            
            <div class="transaction-details">
                <h4>Transaction Details</h4>
                <p><strong>Product:</strong> <?php echo htmlspecialchars($transaction['product_name']); ?></p>
                <p><strong>Total Amount:</strong> EGP <?php echo number_format($transaction['total_price'] + $transaction['security_deposit'], 2); ?></p>
                <p><strong>Transaction ID:</strong> #<?php echo $transaction['id']; ?></p>
                <p><strong>Status:</strong> <span class="badge badge-warning">Pending Approval</span></p>
            </div>

            <div class="btn-container">
                <a href="profile.php" class="btn btn-primary">View My Orders</a>
                <a href="index.php" class="btn btn-secondary">Continue Shopping</a>
            </div>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
</body>
</html> 