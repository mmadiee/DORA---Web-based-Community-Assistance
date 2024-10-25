<?php include 'includes/config.php';?>
<?php 

session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:/index.php');
}
?>

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to DORA</title>

    <link href="css/index.css" rel="stylesheet">
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
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php echo'
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
                        <a class="nav-link" href="dv_userdashboard.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
                '?>
            </div>
        </div>
    </nav>


    <!--CAROUSEL-->
    <div id="carouselMain" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button>
            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="3" aria-label="Slide 4"></button>
          </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
                <img src="img/index/welcome.jpg" class="d-block w-100">
                <div class="carousel-caption bottom-0 mb-5">
                    <h1 class="display-5 fw-bold">Welcome to DORA</h1>
                    <p class="mt-5 fs-5">Development of Rural Areas</p>
                    <a href="about.php" class="btn btn-outline-light px-4 py-2 fs-7 mt-4">Learn More</a>
                    <a href="contact.php" class="btn btn-outline-light px-4 py-2 fs-7 mt-4">Contact Us</a>
                </div>      
          </div>
          
          <div class="carousel-item">
            <img src="img/index/donation.jpg" class="d-block w-100">
            <div class="carousel-caption bottom-0 mb-5">
                <h1 class="display-5 fw-bold">Donations</h1>
                <p class="mt-5 fs-5">Get information on ongoing donation drives</p>
                <a href="donation.php" class="btn btn-outline-light px-4 py-2 fs-7 mt-4">Browse Projects</a>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/index/volunteer.jpg" class="d-block w-100">
            <div class="carousel-caption bottom-0 mb-5">
                <h1 class="display-5 fw-bold">Volunteers</h1>
                <p class="mt-5 fs-5">Opportunities to help the community</p>
                <a href="volunteer.php" class="btn btn-outline-light px-4 py-2 fs-7 mt-4">Browse Projects</a>
            </div>
          </div>
          <div class="carousel-item">
            <img src="img/index/assistance.jpg" class="d-block w-100">
            <div class="carousel-caption bottom-0 mb-5">
                <h1 class="display-5 fw-bold">Assistance</h1>
                <p class="mt-5 fs-5">Browse and apply to different assistance projects.</p>
                <a href="assistance.php" class="btn btn-outline-light px-4 py-2 fs-7 mt-4">Browse Projects</a>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>