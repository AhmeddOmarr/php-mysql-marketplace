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

// Check if transaction details exist in session
if (!isset($_SESSION['transaction'])) {
    header('Location: index.php');
    exit();
}

$transaction = $_SESSION['transaction'];
$user_id = $_SESSION['id'];

// Get transaction details from database
$transaction_details = $query->executeQuery("SELECT t.*, p.name as product_name, 
                       (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.id LIMIT 1) as image 
                       FROM transactions t 
                       JOIN products p ON t.product_id = p.id 
                       WHERE t.id = {$transaction['id']} AND t.user_id = $user_id 
                       LIMIT 1")->fetch_assoc();

if (!$transaction_details) {
    header('Location: index.php');
    exit();
}

// Handle payment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would typically integrate with a payment gateway
    // For now, we'll just update the transaction status to pending for admin approval
    $address = $query->validate($_POST['address']);
    if ($query->executeQuery("UPDATE transactions SET status = 'pending', address = '$address' WHERE id = {$transaction['id']} AND user_id = $user_id")) {
        // Store transaction ID in session for success page
        $_SESSION['pending_transaction_id'] = $transaction['id'];
        
        // Clear transaction from session
        unset($_SESSION['transaction']);
        
        // Redirect to success page
        header('Location: payment-success.php');
        exit();
    } else {
        $error = "Error processing payment. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - <?php echo htmlspecialchars($transaction_details['product_name']); ?></title>
    <link rel="stylesheet" href="./src/css/bootstrap.min.css">
    <link rel="stylesheet" href="./src/css/style.css">
    <style>
        .payment-form {
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
        .product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
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

    <div class="container">
        <div class="payment-form">
            <h2 class="text-center mb-4">Payment Details</h2>
            
            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo $error; ?></div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-md-4">
                    <img src="uploads/<?php echo htmlspecialchars($transaction_details['image']); ?>" 
                         alt="<?php echo htmlspecialchars($transaction_details['product_name']); ?>"
                         class="product-image">
                </div>
                <div class="col-md-8">
                    <h4><?php echo htmlspecialchars($transaction_details['product_name']); ?></h4>
                    <p class="text-muted">Rental Period: <?php echo date('M d, Y', strtotime($transaction_details['rental_start_date'])); ?> 
                       to <?php echo date('M d, Y', strtotime($transaction_details['rental_end_date'])); ?></p>
                </div>
            </div>

            <div class="rental-summary">
                <h4>Payment Summary</h4>
                <div class="row">
                    <div class="col-6">Total Days:</div>
                    <div class="col-6 text-right"><?php echo $transaction_details['total_days']; ?> days</div>
                </div>
                <div class="row">
                    <div class="col-6">Price per Day:</div>
                    <div class="col-6 text-right">EGP <?php echo number_format($transaction_details['total_price'] / $transaction_details['total_days'], 2); ?></div>
                </div>
                <div class="row">
                    <div class="col-6">Security Deposit:</div>
                    <div class="col-6 text-right">EGP <?php echo number_format($transaction_details['security_deposit'], 2); ?></div>
                </div>
                <div class="row mt-3">
                    <div class="col-6"><strong>Total Amount:</strong></div>
                    <div class="col-6 text-right"><strong>EGP <?php echo number_format($transaction_details['total_price'] + $transaction_details['security_deposit'], 2); ?></strong></div>
                </div>
            </div>

            <form method="POST" id="paymentForm">
                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required 
                           pattern="[0-9]{16}" placeholder="1234 5678 9012 3456">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="expiry">Expiry Date</label>
                            <input type="text" class="form-control" id="expiry" name="expiry" required 
                                   pattern="(0[1-9]|1[0-2])\/([0-9]{2})" placeholder="MM/YY" maxlength="5">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cvv">CVV</label>
                            <input type="text" class="form-control" id="cvv" name="cvv" required 
                                   pattern="[0-9]{3}" placeholder="123" maxlength="3">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="card_name">Name on Card</label>
                    <input type="text" class="form-control" id="card_name" name="card_name" required>
                </div>

                <div class="form-group">
                    <label for="address">Delivery Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required 
                              placeholder="Enter your complete delivery address"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Pay Now</button>
            </form>
        </div>
    </div>

    <?php include './includes/footer.php'; ?>

    <script src="./src/js/jquery-3.3.1.min.js"></script>
    <script src="./src/js/bootstrap.min.js"></script>
    <script>
        // Format card number input
        document.getElementById('card_number').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.substr(0, 16);
            e.target.value = value;
        });

        // Format expiry date input
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substr(0, 2) + '/' + value.substr(2);
            }
            e.target.value = value;

            // Validate expiry date
            if (value.length === 5) {
                let [month, year] = value.split('/');
                let currentDate = new Date();
                let currentYear = currentDate.getFullYear() % 100; // Get last 2 digits
                let currentMonth = currentDate.getMonth() + 1; // JavaScript months are 0-based

                if (parseInt(month) < 1 || parseInt(month) > 12) {
                    e.target.setCustomValidity('Invalid month');
                } else if (parseInt(year) < currentYear || 
                          (parseInt(year) === currentYear && parseInt(month) < currentMonth)) {
                    e.target.setCustomValidity('Card has expired');
                } else {
                    e.target.setCustomValidity('');
                }
            }
        });

        // Format CVV input
        document.getElementById('cvv').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.substr(0, 3);
            e.target.value = value;
        });
    </script>
</body>
</html> 