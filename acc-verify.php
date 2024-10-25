<?php 
require "includes/config.php";
$email = "";
$errors = array();

$acctype = 0; 

    
if (isset($_POST['submit'])) {
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    if ($usertype === "Donor-Volunteer") {
        $acctype = 1;
        $_SESSION['acctype'] = $acctype;
    } elseif ($usertype === "Assistance") {
        $acctype = 2;
        $_SESSION['acctype'] = $acctype;
    } elseif ($usertype === "SocialWorker") {
        $acctype = 3;
        $_SESSION['acctype'] = $acctype;
    }
}

if (isset($_POST['country_code']) && isset($_POST['contact'])) {
    $countryCode = $_POST['country_code'];
    $contact = $_POST['contact'];
    $full_contact = $countryCode . $contact;
    $_SESSION['full_contact'] = $full_contact; 
}

if (isset($_SESSION['full_contact'])) {
    $full_contact = $_SESSION['full_contact'];
}

if (!empty($_SESSION['acctype'])){
    $acctype = $_SESSION['acctype'];
}

if (!empty($_GET['acctype'])){
    $acctype = $_GET['acctype'];
}

$table = "";
$link = "";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

function sendVerificationEmail($email, $code, $acctype) {
    $subject = "Account Verification Code";

    $message = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f2f2f2;
                margin: 0;
                padding: 0;
            }
            .container {
                background-color: #ffffff;
                padding: 20px;
                text-align: center;
                max-width: 600px;
                margin: 20px auto;
            }
            .header {
                background-color: #007bff;
                color: #ffffff;
                padding: 10px;
            }
            .message {
                padding: 20px;
                text-align: center;
            }
            .button {
                margin-top: 20px;
                text-align: center;
            }
            .btn {
                display: inline-block;
                background-color: #007bff;
                padding: 10px 20px;
                text-decoration: none;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>{$subject}</h1>
            </div>
            <div class='message'>
                <p>Your account verification code is: <b>{$code}</b></p>
            </div>
            <div class='button'>
                <a href='https://projectsbydora.com' class='btn' style='color: #ffffff;'>
                    Visit Our Website
                </a>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'projectsbydora@gmail.com';
    $mail->Password = 'tdxytcpjqcrripgu';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('projectsbydora@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    if ($mail->send()) {
        $info = "We've sent a verification code to your email - $email";
        $_SESSION['info'] = $info;
        $_SESSION['email'] = $email;
        header('location: user-otp.php?acctype=' . $acctype);
        exit();
    } else {
        $errors['otp-error'] = "Failed while sending code!";
    }
}


//check account type
switch ($acctype) {
    case 1:
        $table = "tbl_dv_accs";
        $link = "Views/Donors-Volunteers/index.php";
        break;
    case 2:
        $table = "tbl_appli_accs";
        $link = "Views/Assistance/assistance_index.php";
        break;
    case 3:
        $table = "tbl_sw_accs";
        $link = "Views/SocialWorkers/social_workerhome.php";
        break;
    default:
        echo "";
}



function isValidLName($lname) {
    return preg_match("/^[a-zA-Z ]+$/", $lname);
}
function isValidFName($fname) {
    return preg_match("/^[a-zA-Z ]+$/", $fname);
}
function isValidMName($mname) {
    return preg_match("/^[a-zA-Z ]+$/", $mname);
}

function isValidEmail($email) {
    return preg_match("/@gmail\.com$/i", $email);
}

function isValidContact($contact) {
    return preg_match("/^\d{10}$/", $contact);
}

// account registration
if(isset($_POST['submit'])){
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $paypal_account = mysqli_real_escape_string($conn, $_POST['paypal_account']);
    $age = mysqli_real_escape_string($conn, $_POST['birthday']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $municipality = mysqli_real_escape_string($conn, $_POST['municipality']);
    $brgy = mysqli_real_escape_string($conn, $_POST['brgy']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    

    // Check if the image is uploaded and is not empty
    if (!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        $errors[] = 'Please upload a profile picture.';
    } else {
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/'.$image;

        if ($image_size > 2000000) {
            $errors[] = 'Image size is too large';
        } else {
            $select = mysqli_query($conn, "SELECT * FROM $table WHERE email = '$email'");
            
            if(mysqli_num_rows($select) > 0){
                $errors[] = 'User already exists'; 
            } else {
                if($pass != $cpass){
                    $errors[] = 'Confirm password does not match!';
                } elseif(strlen($_POST['password']) < 8){
                    $errors[] = 'Password must be at least 8 characters long';
                } elseif(!preg_match("/[A-Za-z]/", $_POST['password']) || !preg_match("/\d/", $_POST['password'])){
                    $errors[] = 'Password must contain both letters and numbers';
                } elseif(!isValidLName($lname)) {
                    $errors[] = 'Please enter a valid Last name.';
                } elseif(!isValidFName($fname)) {
                    $errors[] = 'Please enter a valid First name.';
                } elseif(!isValidMName($mname)) {
                    $errors[] = 'Please enter a valid middle name.';
                } elseif(!isValidEmail($email)) {
                    $errors[] = 'Please enter a valid email ending with "@gmail.com".';
                } elseif(!isValidContact($contact)) {
                    $errors[] = 'Please enter a valid contact number (10 digits only).';
                } else {
                    // Check if the valid_image is uploaded and is not empty
                    if (isset($_FILES['valid_image']) && $_FILES['valid_image']['error'] != UPLOAD_ERR_NO_FILE) {
                        $valid_image = $_FILES['valid_image']['name'];
                        $valid_image_size = $_FILES['valid_image']['size'];
                        $valid_image_tmp_name = $_FILES['valid_image']['tmp_name'];

                        $valid_image_folder = 'uploaded_valid_id/' . $valid_image; // Updated folder path for valid images

                        if ($valid_image_size > 2000000) {
                            $errors[] = 'Valid image size is too large';
                        } else {
                            // Move the valid image to the "valid_images" folder
                            move_uploaded_file($valid_image_tmp_name, $valid_image_folder);
                        }
                    } else {
                        $valid_image = ''; // Set an empty value if valid_image is not uploaded
                    }

                    if ($usertype === "Donor-Volunteer") {
                        $code = rand(999999, 111111);
                        $status = 0;
                    
                        // Retrieve the 'birthday' and 'idtype' from the POST data
                        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
                        $idtype = mysqli_real_escape_string($conn, $_POST['idtype']);
                    
                        $insert = mysqli_query($conn, "INSERT INTO `tbl_dv_accs` (lname, fname, mname, email, birthday, gender, full_contact, city, municipality, brgy, street, occupation, 
                        usertype, password, image, idtype, valid_image, code, status) VALUES ('$lname', '$fname', '$mname', '$email', '$birthday', '$gender', '$full_contact', '$city', 
                        '$municipality', '$brgy', '$street', '$occupation', '$usertype', '$pass', '$image', '$idtype', '$valid_image', $code, $status)");

                        if ($insert) {
                            move_uploaded_file($image_tmp_name, $image_folder);
                            sendVerificationEmail($_POST["email"], $code, $acctype);
                        } else {
                            $errors[] = 'Registration failed: ' . mysqli_error($conn);
                        }
                    }
                    if ($usertype === "Assistance") {
                        $code = rand(999999, 111111);
                        $status = 0;
                    
                        // Retrieve the 'birthday' and 'idtype' from the POST data
                        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
                        $idtype = mysqli_real_escape_string($conn, $_POST['idtype']);
                    
                        $insert = mysqli_query($conn, "INSERT INTO `tbl_appli_accs` (lname, fname, mname, email, birthday, gender, full_contact, city, municipality, brgy, street, occupation, 
                        usertype, password, image, idtype, valid_image, code, status) VALUES ('$lname', '$fname', '$mname', '$email', '$birthday', '$gender', '$full_contact', '$city', 
                        '$municipality', '$brgy', '$street', '$occupation', '$usertype', '$pass', '$image', '$idtype', '$valid_image', $code, $status)");
                
                        if ($insert) {
                            move_uploaded_file($image_tmp_name, $image_folder);
                            sendVerificationEmail($_POST["email"], $code, $acctype);
                        } else {
                            $errors[] = 'Registration failed: ' . mysqli_error($conn);
                        }
                    }
                    if ($usertype === "SocialWorker") {
                        $code = rand(999999, 111111);
                        $status = 'Pending';
                    
                        // Retrieve the 'birthday' and 'idtype' from the POST data
                        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
                        $idtype = mysqli_real_escape_string($conn, $_POST['idtype']);
                    
                        $insert = mysqli_query($conn, "INSERT INTO `tbl_sw_accs` (lname, fname, mname, email, paypal_account, birthday, gender, full_contact, city, municipality, brgy, street, occupation, 
                        usertype, password, image, idtype, valid_image, code, status, submit_date) VALUES ('$lname', '$fname', '$mname', '$email', '$paypal_account', '$birthday', '$gender', '$full_contact', '$city', 
                        '$municipality', '$brgy', '$street', '$occupation', '$usertype', '$pass', '$image', '$idtype', '$valid_image', $code, 'Pending', NOW())");
                
                        if ($insert) {
                            move_uploaded_file($image_tmp_name, $image_folder);
                            sendVerificationEmail($_POST["email"], $code, $acctype);
                        } else {
                            $errors[] = 'Registration failed: ' . mysqli_error($conn);
                        }
                    }
                }
            }
        }
    }
}


//if user click verification code submit button
if (isset($_POST['check'])) {
    $_SESSION['info'] = "";
    $otp_code = mysqli_real_escape_string($conn, $_POST['otp']);
    $check_code = "SELECT * FROM $table WHERE code = $otp_code";
    $code_res = mysqli_query($conn, $check_code);
    $code_res = mysqli_query($conn, $check_code);

    if ($code_res === false) {
        // Handle the case where the SELECT query failed
        $errors['otp-error'] = "Failed to retrieve code from the database: " . mysqli_error($conn);
    } 
    elseif (mysqli_num_rows($code_res) > 0) {
        $fetch_data = mysqli_fetch_assoc($code_res);
        $fetch_code = $fetch_data['code'];
        $email = $fetch_data['email'];
        $code = 0;
        $status = ($table == 'tbl_sw_accs') ? 'Pending' : 1;
        $update_otp = "UPDATE $table SET code = $code, status = '$status' WHERE code = $fetch_code";
        $update_res = mysqli_query($conn, $update_otp);
        
        if ($update_res ) {
            switch ($acctype) {
                case 1:
                    $user_id = $fetch_data['user_id'];
                    $_SESSION['user_id'] = $user_id;
                    $usertype = "Donor-Volunteer";
                    break;
                case 2:
                    $appli_id = $fetch_data['appli_id'];
                    $_SESSION['appli_id'] = $appli_id;
                    $usertype = "Assistance";
                    break;
                case 3:
                    $sw_id = $fetch_data['sw_id'];
                    $_SESSION['sw_id'] = $sw_id;
                    $usertype = "SocialWorker";
                    break;
                default:
                    echo "";
            }
            // Now, based on the user type, you can redirect to the appropriate page.
            switch ($usertype) {
                case "Donor-Volunteer":
                    header('location: Views/Donors-Volunteers/index.php');
                    break;
                case "Assistance":
                    header('location: Views/Assistance/assistance_index.php');
                    break;
                case "SocialWorker":
                    if ($status == 'Pending') {
                        echo '<script type="text/javascript">';
                        echo 'alert("Your Account is still Pending for Approval!");';
                        echo 'window.location.href = "login.php"';
                        echo '</script>';
                        exit;
                    } else {
                        header('location: Views/SocialWorker/socialworker_home.php');
                    }
                    break;
                default:
                    echo "";
            }
            exit();
        } else {
            $errors['otp-error'] = "Failed while updating code!";
        }
    } else {
        $errors['otp-error'] = "You've entered incorrect code!";
    }
}
