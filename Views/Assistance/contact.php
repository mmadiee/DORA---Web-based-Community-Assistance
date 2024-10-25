<?php 
include 'includes/config.php';

session_start();
$appli_id = $_SESSION['appli_id'];

if(!isset($appli_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($appli_id);
   session_destroy();
   header('location:/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DORA</title>

    <link href="css/index.css" rel="stylesheet">
    <link href="css/contact.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">
</head>
<body>
    <!--LOADER-->
    <script src="js/loader.js"></script>    
    <div class="loader"></div>

    <!--NAV BAR-->
    <div class="first-styles">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="assistance_index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assistance.php">Assistance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="a_userdashboard.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </div>

<div class="second-styles">
<div class="popup">
  <div class="popup-content">
    <div class="container">
      <div class="content">

      <div class="left-side">
        <div class="address details">
          <i class="fas fa-map-marker-alt" style="color: #001F54"></i>
          <div class="text-one">Adamson University</div>
        </div>
        <div class="phone details">
          <i class="fas fa-phone-alt" style="color: #001F54"></i>
          <div class="text-one">+6392 0721 6375</div>
        </div>
        <div class="email details">
          <i class="fas fa-envelope" style="color: #001F54"></i>
          <div class="text-one">projectsbydora@gmail.com</div>
        </div>
      </div>
      <div class="right-side">
        <div class="topic-text">Send us a message</div>
        <p>If you have any inquiries about DORA. It is our pleasure to help you!</p>
        
        
        <form action="process_contact.php" method="post">
        <div class="input-box">
            <input type="text" id="name" name="name" placeholder="Enter your name">
        </div>
        <div class="input-box">
            <input type="email" id="email" name="email" placeholder="Enter your email">
        </div>
        <div class="input-box message-box">
            <textarea id="message" name="message" rows="4" placeholder="Enter your inquiries" required></textarea>
        </div>
        <input type="hidden" id="emailHidden" name="emailHidden" value="">
        <div class="button">
            <input type="submit" value="Send Now">
        </div>
        </form>
      </div>
      </div>
    </div>
  </div>
  </div>
</body>
</html>