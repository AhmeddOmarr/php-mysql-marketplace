<?php include 'check.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="icon" href="../favicon.ico">
    <title>Admin Panel | Users</title>
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
        active('users', 'users');
        ?>

        <div class="content-wrapper" style="background-color: white;">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "/"],
                ["title" => "Users", "url" => "#"],
            );
            pagePath('Users', $arr);
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
                                    <h3><?php print_r($query->executeQuery('SELECT * FROM categories')->num_rows) ?>
                                    </h3>
                                    <p>Product types</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3><?php print_r($query->executeQuery('SELECT * FROM products')->num_rows) ?>
                                    </h3>
                                    <p>Number of products</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #f8f9fa;">
                                <h3 class="card-title">Users List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Email(s)</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $data = $query->select('accounts', 'id, name, number, email, username, status', "where role = 'user'");

                                        foreach ($data as $row) {
                                            echo '<tr>';
                                            echo '<td>' . $row['name'] . '</td>';
                                            echo '<td>' . $row['number'] . '</td>';
                                            echo '<td>' . $row['email'] . '</td>';
                                            echo '<td>' . $row['username'] . '</td>';
                                            echo '<td>';
                                            if ($row['status'] == 'active') {
                                                echo '<button class="btn btn-success" onclick="changeStatus(' . $row['id'] . ', \'blocked\')">Active</button>';
                                            } else {
                                                echo '<button class="btn btn-danger" onclick="changeStatus(' . $row['id'] . ', \'active\')">Blocked</button>';
                                            }
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Number</th>
                                            <th>Email(s)</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
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
        $(function () {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
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