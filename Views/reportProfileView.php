<?php
include_once '../Includes/dbconnect.php';
session_start();

if (!isset($_GET['rid'])) {
    header('Location:./inspectorTrports.php');
    exit();
}

if (!isset($_SESSION['Userid']) && empty($_SESSION['Userid']) || $_SESSION['role'] != 3) {
    header('Location: ../index.php');
    exit();
}
$reportid = $_GET['rid'];

//get reports
$sql = "SELECT DISTINCT * FROM user_reports_details WHERE report_id='$reportid'";
$results = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($results);
$reportDate = $row['reportDate'];
$cusID = $row['user_identity_token'];
$cusname = $row['name'];
$empID = $row['inspector_employee_id'];
$accountStatus = $row['account_status'];
$reason = $row['reportReason'];

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
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="../Css/styles.css">
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
                        <a href="#" class="d-block"><?php echo $_SESSION['currentUName']; ?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="inspectorReports.php" class="nav-link active">
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
                            <h1 class="m-0 text-dark">Inspector Reports</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Inspector Reports</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <form action="../Includes/editreports.php" method="POST">
                                        <div class="form-group col-md-3 ml-2">
                                            <label>Report Date<span class="requiredIcon" style="color:red;">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="reportDate" value="<?php echo $reportDate ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row ml-2">
                                            <div class="form-group col-md-5">
                                                <label>Customer ID<span class="requiredIcon" style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="customerID" value="<?php echo $cusID ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-5 offset-md-1">
                                                <label>Reported Employee ID<span class="requiredIcon" style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="inspectorID" value="<?php echo $empID ?>" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row ml-1">
                                            <div class="form-group ml-2 col-md-6">
                                                <label>Customer Name<span class="requiredIcon" style="color:red;">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" name="cname" value="<?php echo $cusname; ?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 offset-2">
                                                <label>Customer Account Status</label>
                                                <div class="input-group">
                                                    <div>
                                                        <?php
                                                        if ($accountStatus == 0) {
                                                            echo '<span class="badge badge-pill badge-success">Active Account</span>';
                                                        } else if ($accountStatus == 1) {
                                                            echo '<span class="badge badge-pill badge-warning">Hold Account</span>';
                                                        } else if ($accountStatus == 2) {
                                                            echo '<span class="badge badge-pill badge-danger">Banned Account</span>';
                                                        } else if ($accountStatus == 3) {
                                                            echo '<span class="badge badge-pill badge-dark">Deactivated Account</span>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-3">
                                            <label>Report Reason<span class="requiredIcon" style="color:red;">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-flag"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="reportReason" value="<?php echo $reason ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4 ml-1">
                                            <label>Account Status<span class="requiredIcon" style="color:red;">*</span></label>
                                            <select id="customeraccountStatus" name="accountStatus" class="form-control select2bs4" data-validation="required" data-validation-error-msg="Please Select Status">
                                                <option value="" selected disabled>--SELECT--</option>
                                                <option value="0">Active</option>
                                                <option value="1">Hold</option>
                                                <option value="2">Banne</option>
                                                <option value="3">Deactivate</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 ml-1">
                                            <button type="submit" name="reportPassenger" class="btn btn-success">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-body -->
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
    <script src="../plugins/form-validator/jquery.form-validator.min.js"></script>
    <script src="../plugins/form-validator/jquery.form-validator.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.js"></script>
    <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
    <script src="../JS/js.js"></script>
    <script>
        $(function() {
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
            });
        });
    </script>
    <?php
    include 'errors.php';
    ?>
</body>

</html>