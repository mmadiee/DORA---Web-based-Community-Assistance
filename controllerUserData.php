<?php 
session_start();
require "includes/config.php";
$email = "";
$name = "";
$errors = array();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

    
//if user click continue button in forgot password form
if(isset($_POST['check-email'])){
    
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    $_SESSION['usertype'] = $usertype; // Store the selected user type in a session variable

    // Determine table based on user type
    if ($usertype === "Donor-Volunteer") {
        $table = "tbl_dv_accs";
    } elseif ($usertype === "Assistance") {
        $table = "tbl_appli_accs";
    } elseif ($usertype === "SocialWorker") {
        $table = "tbl_sw_accs";
    }
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $check_email = "SELECT * FROM $table WHERE email='$email'";
    $run_sql = mysqli_query($conn, $check_email);
    if(mysqli_num_rows($run_sql) > 0){
        $code = rand(999999, 111111);
        $insert_code = "UPDATE $table SET code = $code WHERE email = '$email'";
        $run_query =  mysqli_query($conn, $insert_code);
        if($run_query){
            $subject = "Password Reset Code";
            $message = "Your password reset code is <b>$code</b>";

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'projectsbydora@gmail.com';
            $mail->Password = 'tdxytcpjqcrripgu';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('projectsbydora@gmail.com');

            $mail->addAddress($_POST["email"]);

            $mail->isHTML(true);
            
            $mail->Subject = $subject;
            $mail->Body = $message;

            if($mail->send()){
                $info = "We've sent a password reset OTP to your email - $email";
                $_SESSION['info'] = $info;
                $_SESSION['email'] = $email;
                header('location: password_reset_code.php');
                exit();
            }else{
                $errors['otp-error'] = "Failed while sending code!";
            }
        }else{
            $errors['db-error'] = "Something went wrong!";
        }
    }else{
        $errors['email'] = "This email address does not exist!";
    }
}

//if user click submit reset otp button
if(isset($_POST['check-reset-otp'])){
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    
    $usertype = $_SESSION['usertype']; // Retrieve the user type from session

    // Determine table based on user type for OTP verification
    if ($usertype === "Donor-Volunteer") {
        $table = "tbl_dv_accs";
    } elseif ($usertype === "Assistance") {
        $table = "tbl_appli_accs";
    } elseif ($usertype === "SocialWorker") {
        $table = "tbl_sw_accs";
    }
    
    $check_code = "SELECT * FROM $table WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    if(mysqli_num_rows($code_res) > 0){
        $fetch_data = mysqli_fetch_assoc($code_res);
        $email = $fetch_data['email'];
        $_SESSION['email'] = $email;
        $info = "Please create a new password that you don't use on any other site.";
        $_SESSION['info'] = $info;
        header('location: new-password.php');
        exit();
    }else{
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}

//if user click change password button
if(isset($_POST['change-password'])){
    $_SESSION['info'] = "";
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    
    $usertype = $_SESSION['usertype']; // Retrieve the user type from session

    // Determine table based on user type for changing password
    if ($usertype === "Donor-Volunteer") {
        $table = "tbl_dv_accs";
    } elseif ($usertype === "Assistance") {
        $table = "tbl_appli_accs";
    } elseif ($usertype === "SocialWorker") {
        $table = "tbl_sw_accs";
    }
    
    if($pass !== $cpass){
        $errors['password'] = "Confirm password not matched!";
    } elseif(strlen($_POST['password']) < 8){
        $errors['password'] = 'Password must be at least 8 characters long';
    } elseif(!preg_match("/[A-Za-z]/", $_POST['password']) || !preg_match("/\d/", $_POST['password'])){
        $errors['password'] = 'Password must contain both letters and numbers';
    }else{
        $code = 0;
        $email = $_SESSION['email']; //getting this email using session
        $update_pass = "UPDATE $table SET code = $code, password = '$pass' WHERE email = '$email'";
        $run_query = mysqli_query($conn, $update_pass);
        if($run_query){
            $info = "Your password has been changed. You can now login with your new password.";
            $_SESSION['info'] = $info;
            header('Location: password-changed.php');
        }else{
            $errors['db-error'] = "Failed to change your password!";
        }
    }
}