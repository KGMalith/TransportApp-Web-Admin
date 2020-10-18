<?php
include 'dbconnect.php';
session_start();
if (isset($_GET['uid'])) {

    $userId = $_GET['uid'];
    $query = "DELETE FROM users WHERE uid = '" . $userId . "' ";
    $result = mysqli_query($con, $query);
    $query2 = "DELETE FROM user_details WHERE uid = '" . $userId . "' ";
    $result = mysqli_query($con, $query);

    if ($result) {
        $_SESSION['status'] = "delSuccess";
        header("Location: ../Views/inspectorReports.php");
    } else {
        $_SESSION['status'] = "sqlError";
        header("Location: ../Views/inspectorReports.php");
    }
}
