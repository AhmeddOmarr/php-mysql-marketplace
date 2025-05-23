<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Check if product ID is provided
if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

$product_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Get product details
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: ../index.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_days = $_POST['total_days'];
    $total_price = $_POST['total_price'];
    $security_deposit = $product['security_deposit'];

    // Create transaction record for admin approval
    $stmt = $conn->prepare("INSERT INTO transactions (product_id, user_id, rental_start_date, rental_end_date, total_days, total_price, security_deposit, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iissiid", $product_id, $user_id, $start_date, $end_date, $total_days, $total_price, $security_deposit);
    
    if ($stmt->execute()) {
        $transaction_id = $conn->insert_id;
        
        // Add to cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, number_of_products, rental_start_date, rental_end_date, transaction_id) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iiissi", $user_id, $product_id, $total_days, $start_date, $end_date, $transaction_id);
        
        if ($stmt->execute()) {
            // Store transaction details in session
            $_SESSION['transaction'] = [
                'id' => $transaction_id,
                'product_id' => $product_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
                'total_days' => $total_days,
                'total_price' => $total_price,
                'security_deposit' => $security_deposit
            ];
            
            // Redirect to checkout page
            header('Location: ../checkout.php');
            exit();
        }
    }
    
    $error = "Error creating rental request. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Product - <?php echo htmlspecialchars($product['name']); ?></title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/style.css">
    <style>
        .rental-form {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
        }
        .rental-summary {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container">
        <div class="rental-form">
            <h2 class="text-center mb-4">Rent <?php echo htmlspecialchars($product['name']); ?></h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" id="rentalForm">
                <div class="form-group">
                    <label for="start_date">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" required 
                           min="<?php echo date('Y-m-d'); ?>">
                </div>

                <div class="form-group">
                    <label for="end_date">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" required 
                           min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                </div>

                <input type="hidden" name="total_days" id="total_days">
                <input type="hidden" name="total_price" id="total_price">

                <div class="rental-summary">
                    <h4>Rental Summary</h4>
                    <div class="row">
                        <div class="col-6">Price per Day:</div>
                        <div class="col-6 text-right">EGP <?php echo number_format($product['price_per_day'], 2); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Security Deposit:</div>
                        <div class="col-6 text-right">EGP <?php echo number_format($product['security_deposit'], 2); ?></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total Days:</div>
                        <div class="col-6 text-right" id="summary_days">0</div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total Price:</div>
                        <div class="col-6 text-right" id="summary_price">EGP 0.00</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Proceed to Checkout</button>
            </form>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="../src/js/jquery-3.3.1.min.js"></script>
    <script src="../src/js/bootstrap.min.js"></script>
    <script>
        function calculateTotal() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (startDate && endDate && startDate < endDate) {
                const diffTime = Math.abs(endDate - startDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const pricePerDay = <?php echo $product['price_per_day']; ?>;
                const totalPrice = diffDays * pricePerDay;
                
                document.getElementById('total_days').value = diffDays;
                document.getElementById('total_price').value = totalPrice;
                document.getElementById('summary_days').textContent = diffDays;
                document.getElementById('summary_price').textContent = 'EGP ' + totalPrice.toFixed(2);
            }
        }

        document.getElementById('start_date').addEventListener('change', calculateTotal);
        document.getElementById('end_date').addEventListener('change', calculateTotal);
    </script>
</body>
</html> 