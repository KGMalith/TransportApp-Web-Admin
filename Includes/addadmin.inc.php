<?php

if (isset($_POST['register'])) {
    require_once 'dbconnect.php';
    session_start();


    $name = mysqli_real_escape_string($con, $_POST['name']);
    $mail = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    if (empty($name) || empty($mail) || empty($password)) {
        $_SESSION['status'] = "emptyFields";
        header("Location: ../Views/addAdmins.php");
        exit();
    } else {
        $sql = "SELECT email FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($con);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            $_SESSION['status'] = "sqlError";
            header("Location: ../Views/addAdmins.php");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $mail);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            if ($resultCheck > 0) {
                $_SESSION['status'] = "emailTaken";
                header("Location: ../Views/addAdmins.php");
                exit();
            } else {
                $sql = "INSERT INTO users (user_identity_token,email,password,verified,role) VALUES(?,?,?,?,?)";
                $stmt = mysqli_stmt_init($con);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    $_SESSION['status'] = "sqlError";
                    header("Location: ../Views/addAdmins.php");
                    exit();
                } else {
                    $verification = 1;
                    $hashedpwd = password_hash($password, PASSWORD_BCRYPT);
                    $identity_token = bin2hex(random_bytes(10));
                    $role = 3;

                    mysqli_stmt_bind_param($stmt, "sssss", $identity_token, $mail, $hashedpwd, $verification, $role);
                    if (mysqli_stmt_execute($stmt)) {
                        $user_id = $con->insert_id;

                        $sql2 = "INSERT INTO user_details(uid,name,email) VALUES(?,?,?)";
                        $stmt = mysqli_stmt_init($con);

                        if (!mysqli_stmt_prepare($stmt, $sql2)) {
                            $_SESSION['status'] = "sqlError";
                            header("Location: ../Views/addAdmins.php");
                            exit();
                        } else {

                            mysqli_stmt_bind_param($stmt, "sss", $user_id, $name, $mail);
                            mysqli_stmt_execute($stmt);

                            $_SESSION['status'] = "registerSuccess";
                            header("Location: ../Views/addAdmins.php");
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
