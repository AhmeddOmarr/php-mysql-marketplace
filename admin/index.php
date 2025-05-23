<?php include 'check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../src/images/agarlylogo.png">
    <title>Admin Panel | Dashboard</title>
    <?php include 'includes/css.php'; ?>
    <style>
        :root {
            --primary: #001f3f;
            --secondary: #0a3d78;
            --light-navy: #2c5a8a;
        }
        .small-box {
            color: white !important;
        }
        .bg-info {
            background-color: var(--primary) !important;
        }
        .bg-success {
            background-color: var(--secondary) !important;
        }
        .bg-warning {
            background-color: var(--light-navy) !important;
        }
        .bg-danger {
            background-color: #1a4b8c !important;
        }
        .card {
            border-top: 3px solid var(--primary);
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed" style="background-color: white;">
    <div class="wrapper">

        <?php include 'includes/navbar.php'; ?>

        <?php
        include 'includes/aside.php';
        active('users', 'sellers');
        ?>

        <div class="content-wrapper" style="background-color: white;">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "/"],
                ["title" => "Sellers", "url" => "#"],
            );
            pagePath('Sellers', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>
                                        <?php print_r($query->executeQuery('SELECT * FROM accounts WHERE role = "seller"')->num_rows) ?>
                                    </h3>
                                    <p>Sellers</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="./sellers.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><?php print_r($query->executeQuery('SELECT * FROM accounts WHERE role = "user"')->num_rows) ?>
                                    </h3>
                                    <p>Users</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="./users.php" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><?php print_r($query->executeQuery('SELECT * FROM transactions WHERE status = "pending"')->num_rows) ?>
                                    </h3>
                                    <p>Pending Requests</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-clock"></i>
                                </div>
                                <a href="./transactions.php" class="small-box-footer">View Requests <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php print_r($query->executeQuery('SELECT * FROM transactions')->num_rows) ?>
                                    </h3>
                                    <p>Total Transactions</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="./transactions.php" class="small-box-footer">View All <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Pending Requests Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #f8f9fa;">
                                    <h3 class="card-title">Pending Rental Requests</h3>
                                </div>
                                <div class="card-body">
                                    <table id="pendingRequests" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product</th>
                                                <th>User</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Total Amount</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $pending_requests = $query->executeQuery("SELECT t.*, p.name as product_name, a.name as user_name 
                                                                                    FROM transactions t 
                                                                                    JOIN products p ON t.product_id = p.id 
                                                                                    JOIN accounts a ON t.user_id = a.id 
                                                                                    WHERE t.status = 'pending' 
                                                                                    ORDER BY t.created_at DESC");

                                            while ($row = $pending_requests->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['user_name']) . '</td>';
                                                echo '<td>' . date('M d, Y', strtotime($row['rental_start_date'])) . '</td>';
                                                echo '<td>' . date('M d, Y', strtotime($row['rental_end_date'])) . '</td>';
                                                echo '<td>EGP ' . number_format($row['total_price'] + $row['security_deposit'], 2) . '</td>';
                                                echo '<td>' . date('M d, Y H:i', strtotime($row['created_at'])) . '</td>';
                                                echo '<td>';
                                                echo '<a href="transactions.php" class="btn btn-sm btn-primary">View Details</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Transactions Section -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" style="background-color: #f8f9fa;">
                                    <h3 class="card-title">Recent Transactions</h3>
                                </div>
                                <div class="card-body">
                                    <table id="recentTransactions" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Product</th>
                                                <th>User</th>
                                                <th>Status</th>
                                                <th>Total Amount</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $recent_transactions = $query->executeQuery("SELECT t.*, p.name as product_name, a.name as user_name 
                                                                                       FROM transactions t 
                                                                                       JOIN products p ON t.product_id = p.id 
                                                                                       JOIN accounts a ON t.user_id = a.id 
                                                                                       ORDER BY t.created_at DESC 
                                                                                       LIMIT 5");

                                            while ($row = $recent_transactions->fetch_assoc()) {
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                                echo '<td>' . htmlspecialchars($row['user_name']) . '</td>';
                                                echo '<td><span class="badge badge-' . 
                                                    ($row['status'] === 'pending' ? 'warning' : 
                                                    ($row['status'] === 'approved' ? 'success' : 'danger')) . 
                                                    '">' . ucfirst($row['status']) . '</span></td>';
                                                echo '<td>EGP ' . number_format($row['total_price'] + $row['security_deposit'], 2) . '</td>';
                                                echo '<td>' . date('M d, Y H:i', strtotime($row['created_at'])) . '</td>';
                                                echo '<td>';
                                                echo '<a href="transactions.php" class="btn btn-sm btn-primary">View Details</a>';
                                                echo '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Main Footer - Copyright removed -->
        <footer class="main-footer" style="background-color: var(--primary); color: white;">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Admin Panel</strong>
        </footer>
    </div>

    <!-- SCRIPTS -->
    <script src="../src/js/jquery.min.js"></script>
    <script src="../src/js/adminlte.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../src/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->
    <script src="../src/js/jquery.dataTables.min.js"></script>
    <script src="../src/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#pendingRequests, #recentTransactions').DataTable({
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

    <script>
        function changeStatus(userId, newStatus) {
            window.location.href = "change_status.php?userId=" + userId + "&newStatus=" + newStatus + "&userrole=user";
        }
    </script>

</body>

</html>