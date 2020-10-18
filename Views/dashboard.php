<?php
session_start();
include_once '../Includes/dbconnect.php';

if (!isset($_SESSION['Userid']) && empty($_SESSION['Userid']) || $_SESSION['role'] != 3) {
    header('Location: ../index.php');
    exit();
}
$uid = $_SESSION['Userid'];
//Get User Details
$query = "SELECT name from user_details WHERE uid  = '$uid'";
$resultSet = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($resultSet);
$userName = $row['name'];
$_SESSION['currentUName'] = $userName;

//get reports
$sql = "SELECT DISTINCT * FROM user_reports_details ORDER BY reportDate DESC";
$results = mysqli_query($con, $sql);

//get num users
$sql = "SELECT COUNT(users.uid) AS numUsers FROM users WHERE users.role = 0";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$usersCount = $row['numUsers'];

//get num inspectors
$sql = "SELECT COUNT(users.uid) AS numUsers FROM users WHERE users.role = 2";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$inspectorCount = $row['numUsers'];

//get num Drivers
$sql = "SELECT COUNT(users.uid) AS numUsers FROM users WHERE users.role = 1";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$driversCount = $row['numUsers'];

//get num Admins
$sql = "SELECT COUNT(users.uid) AS numUsers FROM users WHERE users.role = 3";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
$adminCount = $row['numUsers'];


//sum trip income
$query = "SELECT sum(earnings) AS totalEarnings FROM driver_trip_report";
$resultSet = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($resultSet);
$totalearnings = $row['totalEarnings'];

//Total reports
$query = "SELECT count(report_id) AS totalReports FROM user_reports";
$resultSet = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($resultSet);
$totalreports = $row['totalReports'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>SLTB | Admin</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>


        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="../dist/img/Logo.png" alt="AdminLTE Logo" class="brand-image img-circle" style="opacity: .8">
                <span class="brand-text font-weight-light">SLTB</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $_SESSION['currentUName'];?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link active">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="inspectorReports.php" class="nav-link">
                                <i class="nav-icon fa fa-flag"></i>
                                <p>
                                    Inspector Reports
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="addInspectors.php" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Inspectors
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="addAdmins.php" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Add New Admins
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="../Includes/logout.php" class="nav-link">
                                <i class="nav-icon fas fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Dashboard</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-tie"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Inspectors</span>
                                    <span class="info-box-number">
                                        <?php echo $inspectorCount ?>
                                    </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Members</span>
                                    <span class="info-box-number"><?php echo $usersCount ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-bus-alt"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Drivers</span>
                                    <span class="info-box-number"><?php echo $driversCount ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-user-shield"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Admins</span>
                                    <span class="info-box-number"><?php echo $adminCount ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <!-- TABLE: LATEST Reoprts -->
                            <div class="card">
                                <div class="card-header border-transparent">
                                    <h3 class="card-title">Latest Reports</h3>

                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table m-0">
                                            <thead>
                                                <tr>
                                                    <th>Report Date</th>
                                                    <th>UserID</th>
                                                    <th>Inspector ID</th>
                                                    <th>Reason</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $a = 0;
                                                while ($a < 5 && $row = mysqli_fetch_assoc($results)) {
                                                    $reportid = $row['report_id'];
                                                    $reportDate = $row['reportDate'];
                                                    $userID = $row['user_identity_token'];
                                                    $empID = $row['inspector_employee_id'];
                                                    $reason = $row['reportReason'];
                                                ?>
                                                    <tr>
                                                        <td><?php echo $reportDate ?></td>
                                                        <td><?php echo $userID ?></td>
                                                        <td><?php echo $empID ?></td>
                                                        <td><?php echo $reason ?></td>
                                                    </tr>
                                                <?php
                                                    $a = $a + 1;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <a href="inspectorReports.php" class="btn btn-sm btn-secondary float-right">View All Reports</a>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box mb-3 bg-info">
                                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Income</span>
                                    <span class="info-box-number"><?php echo $totalearnings ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <div class="info-box mb-3 bg-danger">
                                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Total Reports</span>
                                    <span class="info-box-number"><?php echo $totalreports ?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->


        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                <b>Powered By</b> <img src="../dist/img/3.png" alt="User Image">
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2020 <a>SLTB</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
    <script src="../plugins/sweetalert2/sweetalert2.all.min.js"></script>
    <?php
    include 'errors.php';
    ?>
</body>

</html>