<?php
include 'check.php';

$user_id = $_SESSION['id'];

// Handle payment redirection
if (isset($_POST['proceed_to_payment'])) {
    // Create transaction record for each cart item
    $cart_items = $query->executeQuery("SELECT c.*, p.name, p.price_current, p.price_old, p.security_deposit 
                                      FROM cart c 
                                      JOIN products p ON c.product_id = p.id 
                                      WHERE c.user_id = $user_id");
    
    $success = true;
    while ($item = $cart_items->fetch_assoc()) {
        $product_id = $item['product_id'];
        $total_price = $item['price_current'] * $item['number_of_products'];
        $security_deposit = $item['security_deposit'];
        
        // Check if this is a rental item
        $is_rental = !empty($item['rental_start_date']);
        
        if ($is_rental) {
            $rental_start_date = $item['rental_start_date'];
            $rental_end_date = $item['rental_end_date'];
            $total_days = $item['total_days'];
            
            $insert_query = "INSERT INTO transactions (user_id, product_id, total_price, security_deposit, 
                            rental_start_date, rental_end_date, total_days, status) 
                            VALUES ($user_id, $product_id, $total_price, $security_deposit, 
                            '$rental_start_date', '$rental_end_date', $total_days, 'pending')";
        } else {
            // For non-rental items, use current date as start and end date
            $current_date = date('Y-m-d');
            $insert_query = "INSERT INTO transactions (user_id, product_id, total_price, security_deposit, 
                            rental_start_date, rental_end_date, total_days, status) 
                            VALUES ($user_id, $product_id, $total_price, $security_deposit, 
                            '$current_date', '$current_date', 1, 'pending')";
        }
        
        if (!$query->executeQuery($insert_query)) {
            $success = false;
            break;
        }
        
        // Store the last transaction ID in session
        $last_id = $query->executeQuery("SELECT LAST_INSERT_ID() as id")->fetch_assoc()['id'];
        $_SESSION['transaction'] = [
            'id' => $last_id,
            'total_price' => $total_price,
            'security_deposit' => $security_deposit
        ];
    }
    
    if ($success) {
        // Clear the cart
        $query->executeQuery("DELETE FROM cart WHERE user_id = $user_id");
        // Redirect to payment page
        header('Location: payment.php');
        exit();
    } else {
        $error = "Error creating transaction. Please try again.";
    }
}

$user = $query->executeQuery("SELECT * FROM accounts WHERE id = $user_id")->fetch_assoc();
$cart = $query->executeQuery("SELECT c.*, p.name, p.price_current, p.price_old, p.security_deposit, t.status as transaction_status,
                            (SELECT pi.image_url FROM product_images pi WHERE pi.product_id = p.id LIMIT 1) as image 
                            FROM cart c 
                            JOIN products p ON c.product_id = p.id 
                            LEFT JOIN transactions t ON c.transaction_id = t.id 
                            WHERE c.user_id = $user_id");

$price_old_Sum = 0;
$price_current_Sum = 0;
$security_deposit_Sum = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="icon" type="image/png" href="./src/images/agarlylogo.png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            color: #34495e;
        }

        .container {
            width: 90%;
            overflow-x: auto;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            font-size: 2.5em;
            font-weight: bold;
        }

        h3 {
            color: #3498db;
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .user-information,
        .cart-summary {
            margin-bottom: 40px;
        }

        .user-information ul {
            list-style-type: none;
            padding: 0;
            font-size: 1.1em;
            color: #7f8c8d;
        }

        .user-information li {
            margin-bottom: 12px;
        }

        .user-information li strong {
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            padding: 15px 20px;
            text-align: left;
            border: 1px solid #e0e0e0;
            font-size: 1.1em;
        }

        th {
            background-color: #f0f0f0;
            color: #3498db;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0f7fa;
            transition: background-color 0.3s ease;
        }

        .total {
            font-size: 1.4em;
            font-weight: bold;
            color: #2c3e50;
            margin-top: 25px;
            text-align: right;
        }

        .total p {
            margin: 15px 0;
        }

        .total span {
            color: #e74c3c;
        }

        .price del {
            color: #e74c3c;
            font-size: 14px;
        }

        .price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price span {
            color: #2ecc71;
            font-weight: bold;
        }

        .cart-summary {
            border-top: 2px solid #e0e0e0;
            padding-top: 20px;
        }

        del {
            font-weight: bold;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        .continue-shopping-btn {
            display: inline-block;
            background-color: #001f3f;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1em;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .continue-shopping-btn:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .continue-shopping-btn[style*="background-color: #6c757d"] {
            background-color: #001f3f !important;
        }

        .continue-shopping-btn[style*="background-color: #6c757d"]:hover {
            background: linear-gradient(135deg, #0043b0, #001f3f) !important;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 20px;
            }

            h2 {
                font-size: 2em;
            }

            h3 {
                font-size: 1.2em;
            }

            table th,
            table td {
                font-size: 1em;
                padding: 10px;
            }

            .total p {
                font-size: 1.2em;
            }

            .user-information ul {
                font-size: 1em;
            }

            .price span {
                font-size: 1em;
            }

            .price del {
                font-size: 12px;
            }
        }

        @media (max-width: 480px) {
            .container {
                width: 100%;
                padding: 10px;
            }

            h2 {
                font-size: 1.8em;
            }

            h3 {
                font-size: 1.1em;
            }

            .user-information ul {
                font-size: 0.9em;
            }

            table th,
            table td {
                font-size: 0.9em;
                padding: 8px;
            }

            .price span {
                font-size: 0.9em;
            }

            .total p {
                font-size: 1em;
            }

            .cart-summary {
                padding-top: 15px;
            }

            .continue-shopping-btn {
                padding: 10px 20px;
                font-size: 1em;
            }
        }

        .rental-info {
            background-color: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }
        .rental-dates {
            font-size: 0.9em;
            color: #666;
        }
        .security-deposit {
            color: #e74c3c;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Checkout</h2>

        <div class="user-information">
            <h3>User Information</h3>
            <ul>
                <li><strong>Name:</strong> <?= htmlspecialchars($user['name']); ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></li>
                <li><strong>Phone Number:</strong> <?= htmlspecialchars($user['number']); ?></li>
            </ul>
        </div>

        <div class="cart-summary">
            <h3>Cart Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Product Name</th>
                        <th>Type</th>
                        <th>Price</th>
                        <th>Quantity/Days</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($cart as $index => $item) {
                        $is_rental = !empty($item['rental_start_date']);
                        $price_old = $item['price_old'];
                        $price_current = $item['price_current'];
                        $quantity = $item['number_of_products'];

                        if ($is_rental) {
                            $price_old_Sum += $price_old * $quantity;
                            $price_current_Sum += $price_current * $quantity;
                            $security_deposit_Sum += $item['security_deposit'];
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <?= htmlspecialchars($item['name']); ?>
                                <div class="rental-info">
                                    <div class="rental-dates">
                                        From: <?= date('M d, Y', strtotime($item['rental_start_date'])); ?><br>
                                        To: <?= date('M d, Y', strtotime($item['rental_end_date'])); ?>
                                    </div>
                                    <div class="security-deposit">
                                        Security Deposit: EGP <?= number_format($item['security_deposit'], 2); ?>
                                    </div>
                                </div>
                            </td>
                            <td>Rental</td>
                            <td>
                                <div class="price">
                                    <del>EGP <?= number_format($price_old, 2); ?></del>
                                    <span>EGP <?= number_format($price_current, 2); ?></span>
                                </div>
                            </td>
                            <td><?= $quantity ?> days</td>
                            <td>
                                <div class="price">
                                    <del>EGP <?= number_format($price_old * $quantity, 2); ?></del>
                                    <span>EGP <?= number_format($price_current * $quantity, 2); ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php
                        } else {
                            $price_old_Sum += $price_old * $quantity;
                            $price_current_Sum += $price_current * $quantity;
                    ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($item['name']); ?></td>
                            <td>Purchase</td>
                            <td>
                                <div class="price">
                                    <del>EGP <?= number_format($price_old, 2); ?></del>
                                    <span>EGP <?= number_format($price_current, 2); ?></span>
                                </div>
                            </td>
                            <td><?= $quantity ?></td>
                            <td>
                                <div class="price">
                                    <del>EGP <?= number_format($price_old * $quantity, 2); ?></del>
                                    <span>EGP <?= number_format($price_current * $quantity, 2); ?></span>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="total">
            <p>Total (Old Price): <span><del>EGP <?= number_format($price_old_Sum, 2); ?></del></span></p>
            <p>Total (Current Price): <span style="color: #2ecc71">EGP <?= number_format($price_current_Sum, 2); ?></span></p>
            <?php if ($security_deposit_Sum > 0): ?>
                <p>Total Security Deposit: <span style="color: #e74c3c">EGP <?= number_format($security_deposit_Sum, 2); ?></span></p>
                <p>Grand Total: <span style="color: #2ecc71">EGP <?= number_format($price_current_Sum + $security_deposit_Sum, 2); ?></span></p>
            <?php endif; ?>
        </div>

        <div class="button-container">
            <form method="POST" style="display: inline;">
                <button type="submit" name="proceed_to_payment" class="continue-shopping-btn">Proceed to Payment</button>
            </form>
        </div>
    </div>

</body>

</html>