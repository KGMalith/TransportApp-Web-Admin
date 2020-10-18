<?php
if(isset($_GET['rid'])){
    include_once 'dbconnect.php';
    session_start();

    $reportid = $_GET['rid'];

    $query = "DELETE FROM user_reports WHERE report_id='$reportid'";
    $result = mysqli_query($con,$query);

    if($result){
        $_SESSION['status'] = "delSuccess";
        header("Location: ../Views/inspectorReports.php");
        exit();

    }else{
        $_SESSION['status'] = "sqlError";
        header("Location: ../Views/addInspectors.php");
        exit();
    }
}