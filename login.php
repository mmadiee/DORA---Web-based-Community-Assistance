<?php include 'includes/config.php'; ?>
<?php
    // SQL query to update proj_stat to 'GOAL REACHED' if the goal is reached
    $sqlUpdateGoalReached = "
        UPDATE tbl_don_proj
        SET proj_stat = 'GOAL REACHED'
        WHERE proj_stat = 'ON GOING'
          AND don_project_id IN (
              SELECT dp.don_project_id
              FROM tbl_don_proj dp
              INNER JOIN (
                  SELECT don_project_id, SUM(amount) AS total_amount
                  FROM tbl_transaction
                  WHERE stat = 'VERIFIED'
                  GROUP BY don_project_id
              ) t ON dp.don_project_id = t.don_project_id
              WHERE dp.proj_stat != 'COMPLETED' 
                AND dp.proj_stat != 'FUNDED'
                AND t.total_amount >= dp.goal
          );";
            
    $conn->query($sqlUpdateGoalReached);
    ?>

    <?php
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the current date
    $currentDate = date('Y-m-d');

    // Update tbl_don_proj
    $sqlDonProj = "UPDATE tbl_don_proj SET proj_stat = 'PAST DUE' WHERE proj_stat = 'ON GOING' AND end < '$currentDate' AND proj_stat NOT IN ('GOAL REACHED', 'COMPLETED', 'FUNDED')";
    $conn->query($sqlDonProj);

    // Update tbl_vol_project
    $sqlVolProj = "UPDATE tbl_vol_proj SET proj_stat = 'PAST DUE' WHERE proj_stat = 'ON GOING' AND eventDate < '$currentDate' AND proj_stat NOT IN ('GOAL REACHED', 'COMPLETED', 'FUNDED')";
    $conn->query($sqlVolProj);

    // Update tbl_assistance
    $sqlAssistance = "UPDATE tbl_assistance SET proj_stat = 'PAST DUE' WHERE proj_stat = 'ON GOING' AND deadline < '$currentDate' AND proj_stat NOT IN ('GOAL REACHED', 'COMPLETED', 'FUNDED')";
    $conn->query($sqlAssistance);
    ?>

<?php

session_start();

$errors = array();

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $userFound = false; // Flag to check if the user is found in any table

    // Check 'Donor-Volunteer' table
    $check_donor_volunteer = "SELECT * FROM `tbl_dv_accs` WHERE email = '$email'";
    $result_donor_volunteer = mysqli_query($conn, $check_donor_volunteer);

    if (!$result_donor_volunteer) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_donor_volunteer) > 0) {
        $row = mysqli_fetch_assoc($result_donor_volunteer);
        $fetch_pass = $row['password'];

        if ($password === $fetch_pass) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'Donor-Volunteer'; 

            // Redirect based on usertype
            header('location: Views/Donors-Volunteers/index.php');
            exit;
        } else {
            $userFound = true; // User found, but password incorrect
        }
    }

    // Check 'Assistance' table
    $check_assistance = "SELECT * FROM `tbl_appli_accs` WHERE email = '$email'";
    $result_assistance = mysqli_query($conn, $check_assistance);

    if (!$result_assistance) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_assistance) > 0) {
        $row = mysqli_fetch_assoc($result_assistance);
        $fetch_pass = $row['password'];

        if ($password === $fetch_pass) {
            $_SESSION['appli_id'] = $row['appli_id'];
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'Assistance';

            // Redirect based on usertype
            header('location: Views/Assistance/assistance_index.php');
            exit;
        } else {
            $userFound = true; // User found, but password incorrect
        }
    }
    
     // Check 'Admin' table
    $check_admin = "SELECT * FROM `tbl_admin_accs` WHERE email = '$email'";
    $result_admin = mysqli_query($conn, $check_admin);

    if (!$result_admin) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        $fetch_pass = $row['password'];

        if ($password === $fetch_pass) {
            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'Admin';

            // Redirect based on usertype
            header('location: Views/Admin/admin_home.php');
            exit;
        } else {
            $userFound = true; // User found, but password incorrect
        }
    }

    // Check SocialWorker table
    $check_socialworker = "SELECT * FROM `tbl_sw_accs` WHERE email = '$email'";
    $result_login = mysqli_query($conn, $check_socialworker);

    if (!$result_login) {
        die("Query failed: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result_login) > 0) {
        $row = mysqli_fetch_assoc($result_login);
        $fetch_pass = $row['password'];
        $status = $row['status'];

        if ($status === 'Invalid') {
            $info = "Your account is marked as 'Invalid.' Please check your email for further instructions.";
            $_SESSION['info'] = $info;
            header('location: login.php');
            exit;
        } elseif ($password === $fetch_pass) {
            $_SESSION['sw_id'] = $row['sw_id'];
            $_SESSION['email'] = $email;
            $_SESSION['usertype'] = 'SocialWorker';  

            if ($status === 'Pending') {
                echo '<script type="text/javascript">';
                echo 'alert("Your Social Worker Account is still pending for approval. We will update you through email once you are verified.");';
                echo 'window.location.href = "login.php"';
                echo '</script>';
                exit; 
            } else {
                // Redirect based on usertype
                if ($row['usertype'] === 'SocialWorker') {
                    header('location: Views/SocialWorker/socialworker_home.php');
                    exit;
                }
            } 
        } else {
            $userFound = true; // User found, but password incorrect
        }
    }

    // Check if user is found but password is incorrect
    if ($userFound) {
        $errors['password'] = 'Incorrect password!';
    } else {
        // User not found
        $errors['incorrect'] = 'Email does not exist. Register first.';
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to DORA</title>
    
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

<style>

    .password-container {
        position: relative;
    }

    #togglePassword {
        position: absolute;
        top: 50%;
        right: 55px;
        transform: translateY(-50%);
        cursor: pointer;
    }
    
    #password[type="text"] + #togglePassword::before {
        content: "\f070"; 
    }
    
    
    #password[type="password"] + #togglePassword::before {
        content: "\f06e"; 
    }
    .message{
       margin:10px 0;
       width: 80%;
       border-radius: 5px;
       padding:10px;
       text-align: center;
       background-color: var(--red);
       color:var(--white);
       font-size: 15px;
       margin-left: 45px;
    }

</style>
    
</head>
<body>
  <!--LOADER-->
  <script src="js/loader.js"></script>
    <div class="loader"></div>

<!--NAV BAR-->
<nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="donation.php">Donations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="volunteer.php">Volunteers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assistance.php">Assistance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="form-container">
        
    <div class="form-description">
    <a href="index.php" class="imglogo"><img src="dora_logo.png" width="500" height="135"></a>
    <hr>
    <p >Join the Movement for Community <br>
        Change – Engage and Make a Difference!</p>
    </div>

    <form action="" method="post" enctype="multipart/form-data">
        <h2>Login</h2>
        <?php
        if (isset($errors)) {
            foreach ($errors as $error) {
                echo '<div class="message">' . $error . '</div>';
            }
        }
        ?>

        <!-- START OF THE LOGIN INPUTS -->
        <input type="email" name="email" placeholder="Enter Email" class="box" required>
        
       <div class="password-container">
            <input type="password" name="password" id="password" placeholder="Enter Password" class="box" required>
            <i class="fas fa-eye" id="togglePassword"></i>
        </div>

        
        <br>
        <input type="submit" name="submit" value="Login Now" class="btn btn-primary btn-lg btn-block">
        <p class="pbox"><a href="password-reset.php">Forgot Password</a></p>
        <p class="pbox">Don't have an Account? <a href="privacy_stmnt.php">Register Now</a></p>
    </form>
    </div>
    
    
 
          

 <!--FOOTER-->
 <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="donation.php">Donations</a></li>
            <li><a href="volunteer.php">Volunteers</a></li>
            <li><a href="assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    
<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordInput = document.getElementById("password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
</script>
    
</body>
</html> 