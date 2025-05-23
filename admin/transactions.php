<?php
session_start();
require_once '../config.php';

// Initialize database connection
$query = new Database();

// Check if user is logged in and is admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || 
    !isset($_SESSION['id']) || empty($_SESSION['id']) || 
    !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

// Debug information
error_log("Admin ID: " . $_SESSION['id']);
error_log("Admin Role: " . $_SESSION['role']);

// Handle transaction status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['transaction_id'])) {
    $transaction_id = $query->validate($_POST['transaction_id']);
    $status = $query->validate($_POST['status']);
    $admin_notes = $query->validate($_POST['admin_notes']);
    
    // Update transaction status
    if ($query->executeQuery("UPDATE transactions SET status = '$status', admin_notes = '$admin_notes' WHERE id = $transaction_id")) {
        // If approved, update product availability
        if ($status === 'approved') {
            $query->executeQuery("UPDATE products p 
                                JOIN transactions t ON p.id = t.product_id 
                                SET p.availability_status = 'rented' 
                                WHERE t.id = $transaction_id");
        }
        // If rejected, make product available again
        else if ($status === 'rejected') {
            $query->executeQuery("UPDATE products p 
                                JOIN transactions t ON p.id = t.product_id 
                                SET p.availability_status = 'available' 
                                WHERE t.id = $transaction_id");
        }
        
        $_SESSION['success'] = "Transaction status updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating transaction status.";
    }
    
    header('Location: transactions.php');
    exit();
}

// Get all transactions with related information
$sql = "SELECT t.*, p.name as product_name, pi.image_url as image, a.name as user_name, a.email 
        FROM transactions t 
        JOIN products p ON t.product_id = p.id 
        LEFT JOIN product_images pi ON p.id = pi.product_id 
        JOIN accounts a ON t.user_id = a.id 
        ORDER BY t.created_at DESC";

$result = $query->executeQuery($sql);

// Debug information
if ($result->num_rows === 0) {
    error_log("No transactions found in the database");
    error_log("SQL Query: " . $sql);
}

$transactions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Transactions - Admin Panel</title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/adminlte.min.css">
    <link rel="stylesheet" href="../src/css/dataTables.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Manage Transactions</h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <div class="container-fluid">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php 
                            echo $_SESSION['success'];
                            unset($_SESSION['success']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php 
                            echo $_SESSION['error'];
                            unset($_SESSION['error']);
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-body">
                            <?php if (empty($transactions)): ?>
                                <div class="alert alert-info">
                                    No transactions found.
                                </div>
                            <?php else: ?>
                                <table id="transactionsTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Product</th>
                                            <th>User</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Days</th>
                                            <th>Total Price</th>
                                            <th>Security Deposit</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($transactions as $row): ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td>
                                                    <?php if (!empty($row['image'])): ?>
                                                        <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                                                             alt="<?php echo htmlspecialchars($row['product_name']); ?>"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    <?php endif; ?>
                                                    <?php echo htmlspecialchars($row['product_name']); ?>
                                                </td>
                                                <td>
                                                    <?php echo htmlspecialchars($row['user_name']); ?><br>
                                                    <small class="text-muted"><?php echo htmlspecialchars($row['email']); ?></small>
                                                </td>
                                                <td><?php echo date('M d, Y', strtotime($row['rental_start_date'])); ?></td>
                                                <td><?php echo date('M d, Y', strtotime($row['rental_end_date'])); ?></td>
                                                <td><?php echo $row['total_days']; ?></td>
                                                <td>EGP <?php echo number_format($row['total_price'], 2); ?></td>
                                                <td>EGP <?php echo number_format($row['security_deposit'], 2); ?></td>
                                                <td>
                                                    <span class="badge badge-<?php 
                                                        echo $row['status'] === 'pending' ? 'warning' : 
                                                            ($row['status'] === 'approved' ? 'success' : 'danger'); 
                                                    ?>">
                                                        <?php echo ucfirst($row['status']); ?>
                                                    </span>
                                                </td>
                                                <td><?php echo date('M d, Y H:i', strtotime($row['created_at'])); ?></td>
                                                <td>
                                                    <?php if ($row['status'] === 'pending'): ?>
                                                        <button type="button" class="btn btn-sm btn-success" 
                                                                data-toggle="modal" 
                                                                data-target="#approveModal<?php echo $row['id']; ?>">
                                                            Approve
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger" 
                                                                data-toggle="modal" 
                                                                data-target="#rejectModal<?php echo $row['id']; ?>">
                                                            Reject
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <!-- Approve Modal -->
                                            <div class="modal fade" id="approveModal<?php echo $row['id']; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST">
                                                            <input type="hidden" name="transaction_id" value="<?php echo $row['id']; ?>">
                                                            <input type="hidden" name="status" value="approved">
                                                            
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Approve Rental Request</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Admin Notes</label>
                                                                    <textarea name="admin_notes" class="form-control" rows="3" 
                                                                              placeholder="Add any notes about this approval..."></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-success">Approve Request</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal<?php echo $row['id']; ?>" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="POST">
                                                            <input type="hidden" name="transaction_id" value="<?php echo $row['id']; ?>">
                                                            <input type="hidden" name="status" value="rejected">
                                                            
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Rental Request</h5>
                                                                <button type="button" class="close" data-dismiss="modal">
                                                                    <span>&times;</span>
                                                                </button>
                                                            </div>
                                                            
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label>Rejection Reason</label>
                                                                    <textarea name="admin_notes" class="form-control" rows="3" 
                                                                              placeholder="Please provide a reason for rejection..." required></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Reject Request</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Admin Panel</strong>
        </footer>
    </div>

    <script src="../src/js/jquery.min.js"></script>
    <script src="../src/js/bootstrap.bundle.min.js"></script>
    <script src="../src/js/adminlte.min.js"></script>
    <script src="../src/js/jquery.dataTables.min.js"></script>
    <script src="../src/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true
            });
        });
    </script>
</body>
</html> 