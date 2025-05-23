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

$user_id = $_SESSION['id'];

// Get user's transactions with debug information
$sql = "SELECT t.*, p.name as product_name, pi.image_url as image 
        FROM transactions t 
        JOIN products p ON t.product_id = p.id 
        LEFT JOIN product_images pi ON p.id = pi.product_id 
        WHERE t.user_id = $user_id 
        ORDER BY t.created_at DESC";

$result = $query->executeQuery($sql);
$transactions = $result->fetch_all(MYSQLI_ASSOC);

// Debug information
if (empty($transactions)) {
    error_log("No transactions found for user ID: $user_id");
    error_log("SQL Query: $sql");
}

// Check if request is coming from AJAX/JS
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    // Return JSON data for sidebar
    header('Content-Type: application/json');
    echo json_encode([
        'name' => $_SESSION['name'] ?? 'Not set',
        'email' => $_SESSION['email'] ?? 'Not set'
    ]);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/style.css">
    <style>
        .profile-section {
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        .transaction-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #dee2e6;
        }
        .transaction-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
        }
        .status-pending { background: #001f3f; color: #fff; }
        .status-approved { background: #0043b0; color: #fff; }
        .status-rejected { background: #dc3545; color: #fff; }
        .btn-primary {
            background-color: #001f3f !important;
            border-color: #001f3f !important;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <?php include './includes/header.php'; ?>

    <div class="container py-5">
        <div class="row">
            <!-- Profile Information -->
            <div class="col-md-4">
                <div class="profile-section">
                    <h2 class="mb-4">Profile Information</h2>
                    <div class="mb-3">
                        <label class="text-muted">Name</label>
                        <p class="h5"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Email</label>
                        <p class="h5"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="col-md-8">
                <div class="profile-section">
                    <h2 class="mb-4">Transaction History</h2>
                    
                    <?php if (empty($transactions)): ?>
                        <div class="alert alert-info">
                            You haven't made any transactions yet.
                        </div>
                    <?php else: ?>
                        <?php foreach ($transactions as $transaction): ?>
                            <div class="transaction-card">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <?php if (!empty($transaction['image'])): ?>
                                            <img src="src/images/products/<?php echo htmlspecialchars($transaction['image']); ?>" 
                                                 alt="<?php echo htmlspecialchars($transaction['product_name']); ?>"
                                                 class="transaction-image">
                                        <?php else: ?>
                                            <div class="transaction-image bg-light d-flex align-items-center justify-content-center">
                                                <span class="text-muted">No image</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-7">
                                        <h5><?php echo htmlspecialchars($transaction['product_name']); ?></h5>
                                        <p class="mb-1">
                                            <small class="text-muted">
                                                Transaction ID: #<?php echo $transaction['id']; ?><br>
                                                Date: <?php echo date('M d, Y', strtotime($transaction['created_at'])); ?>
                                            </small>
                                        </p>
                                        <p class="mb-1">
                                            Rental Period: <?php echo date('M d, Y', strtotime($transaction['rental_start_date'])); ?> 
                                            to <?php echo date('M d, Y', strtotime($transaction['rental_end_date'])); ?>
                                        </p>
                                        <p class="mb-0">
                                            Total Amount: EGP <?php echo number_format($transaction['total_price'] + $transaction['security_deposit'], 2); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <span class="status-badge status-<?php echo $transaction['status']; ?>">
                                            <?php echo ucfirst($transaction['status']); ?>
                                        </span>
                                        <?php if (!empty($transaction['admin_notes'])): ?>
                                            <p class="mt-2 mb-0">
                                                <small class="text-muted">
                                                    <?php echo htmlspecialchars($transaction['admin_notes']); ?>
                                                </small>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
</body>
</html>