<?php 
if(isset($_POST['reportPassenger'])){
    include_once 'dbconnect.php';
    session_start();

    $userid = mysqli_real_escape_string($con,$_POST['customerID']);
    $statusChange = mysqli_real_escape_string($con,$_POST['accountStatus']);

    if(empty($statusChange)){
        $_SESSION['status'] = "emptyFields";
        header("Location: ../Views/inspectorReports.php");
        exit();
    }else{
        $query = "UPDATE users SET account_status = '$statusChange' WHERE user_identity_token='$userid'";
        $result = mysqli_query($con,$query);

        if($result){
            $_SESSION['status'] = "reportUpdateSuccess";
            header("Location: ../Views/inspectorReports.php");
            exit();
        }else{
            $_SESSION['status'] = "sqlError";
            header("Location: ../Views/inspectorReports.php");
            exit();
        }
    }

}