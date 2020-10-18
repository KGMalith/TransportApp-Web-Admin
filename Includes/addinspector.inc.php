<?php

    if(isset($_POST['register'])){
        require_once 'dbconnect.php';
        session_start();

        $empID = mysqli_real_escape_string($con,$_POST['empid']); 
        $name = mysqli_real_escape_string($con,$_POST['name']); 
        $mail = mysqli_real_escape_string($con,$_POST['email']); 
        $city = mysqli_real_escape_string($con,$_POST['city']); 
        $password = mysqli_real_escape_string($con, $_POST['password']); 

        if(empty($empID) || empty($name) ||empty($mail) ||empty($city) ||empty($password) ){
            $_SESSION['status'] = "emptyFields";
            header("Location: ../Views/addInspectors.php");
            exit();
        }
        else{
            $sql = "SELECT email FROM users WHERE email=?";
            $stmt = mysqli_stmt_init($con);

            if (!mysqli_stmt_prepare($stmt, $sql)) {
                $_SESSION['status'] = "sqlError";
                header("Location: ../Views/addInspectors.php");
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "s", $mail);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);

                if ($resultCheck > 0) {
                    $_SESSION['status'] = "emailTaken";
                    header("Location: ../Views/addInspectors.php");
                    exit();
                }else{
                    $sql = "INSERT INTO users (user_identity_token,email,password,verified,role) VALUES(?,?,?,?,?)";
                    $stmt = mysqli_stmt_init($con);

                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            $_SESSION['status'] = "sqlError";
                            header("Location: ../Views/addInspectors.php");
                            exit();
                        }else{
                            $status = 1;
                            $hashedpwd = password_hash($password, PASSWORD_BCRYPT);
                            $identity_token = bin2hex(random_bytes(10));
                            $role = 2;

                            mysqli_stmt_bind_param($stmt, "sssss", $identity_token , $mail, $hashedpwd, $status, $role);
                                if (mysqli_stmt_execute($stmt)) {
                                    $user_id = $con->insert_id;

                                    $sql2 = "INSERT INTO user_details(uid,inspector_employee_id,name,email,working_city) VALUES(?,?,?,?,?)";
                                    $stmt = mysqli_stmt_init($con);

                                    if (!mysqli_stmt_prepare($stmt, $sql2)) {
                                        $_SESSION['status'] = "sqlError";
                                        header("Location: ../Views/addInspectors.php");
                                        exit();
                                    } else {

                                        mysqli_stmt_bind_param($stmt, "sssss", $user_id, $empID, $name, $mail, $city);
                                        mysqli_stmt_execute($stmt);

                                        $_SESSION['status'] = "registerSuccess";
                                        header("Location: ../Views/addInspectors.php");
                                        exit();
                                    }
                                }
                        }
                }
            }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($con);
} else {
    header("Location: ../Views/addInspectors.php");
    exit();
}