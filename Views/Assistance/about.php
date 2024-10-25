<?php
include 'includes/config.php';

session_start();
$appli_id = $_SESSION['appli_id'];

if(!isset($appli_id)){
   header('location:/DORA/login.php');
};

if(isset($_GET['logout'])){
   unset($appli_id);
   session_destroy();
   header('location:/DORA/index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DORA</title>

    <link href="css/about.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
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
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="assistance_index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="about.php">About</a>
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

    <!--Main Content-->
    <div class="header">
        <h1>About us</h1>
    </div>
    <section>
        <div class="container logo-image">
            <center><img class="responsive w-25" src="img/about/dora_logo.png"></center>
        </div>
        <div class="container w-75" style="padding: 40px">
            <div class="description">
                <p>
                    The name DORA stands for "<b>Development of Rural Areas</b>". 
                    DORA is a website that provides information beneficial to the community, 
                    specifically those from rural areas who are considered as disadvantaged and underprivileged. 
                    With DORA, people who need help or want to help has a way to access ongoing <b>donation drives</b>, 
                    <b>volunteering opportunities</b>, and <b> assistance</b>.
                </p>
                <p>
                    <br>
                    <b>Our Mission Statement</b><br>
                     DORA provides a thriving online community assistance platform that connects volunteers, those in 
                    need of assistance, and donors, fostering a culture of compassion, empowerment, and support. We are
                    committed to building an online tool where individuals and organizations can come together to make 
                    a positive impact on the community, one act of kindness at a time.
                </p>
                
                <p>
                    <b>Our Vision Statement</b><br>
                    We aspire to build a community where every person can access and provide assistance, fostering 
                    kindness and solidarity. We aim to empower and inspire people to transform their communities by 
                    working together to address pressing social and humanitarian challenges.
                </p>
            </div>
        </div>
    </section>

                </div>
            </div>
        </div>
    </section>
   


    <!--FOOTER-->
    <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>