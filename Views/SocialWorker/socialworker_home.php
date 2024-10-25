<?php
include 'includes/config.php';

session_start();
$sw_id = $_SESSION['sw_id'];

if (!isset($sw_id)) {
   header('location:/login.php');
   exit; 
}

if (isset($_GET['logout'])) {
   unset($sw_id);
   session_destroy();
   header('location:/index.php');
   exit; 
}
?>

<?php
$sw_id = $_SESSION['sw_id'];

function isSocialWorkerLoggedIn()
{
    return isset($_SESSION['sw_id']);
}

if (isset($_POST['start'])) {
    $sw_id = 1; 
    $_SESSION['sw_id'] = $sw_id;

    $login_time = date("Y-m-d H:i:s");
    $sql = "INSERT INTO social_worker_time_tracking (sw_id, login_time) VALUES ('$sw_id', '$login_time')";
    if (mysqli_query($conn, $sql)) {
        echo "Time In: " . $login_time;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

if (isset($_POST['end'])) {
    $sw_id = $_SESSION['sw_id'];

    $logout_time = date("Y-m-d H:i:s");
    $sql = "UPDATE social_worker_time_tracking SET logout_time='$logout_time' WHERE sw_id='$sw_id' AND logout_time IS NULL";
    if (mysqli_query($conn, $sql)) {
      echo '<script type="text/javascript">';
      echo 'alert("You have logged Out!");';
      echo '</script>';
      echo '<meta http-equiv="refresh" content="3;url=login_socialworker.php">';
      echo "Time Out: " . $logout_time;
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
      session_destroy();
    header("Location: /login_socialworker.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Social Worker Home Page</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/home.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">
    
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">

    <style>
        .btn_delete{
            position: left;
            width: 31%;
            height: 40px;
            margin-left: 8px;
            color: white;
            background-color: red;
            border-color: red;
            border-radius: 6px;
        }
        .btn_delete:hover{
            position: left;
            width: 31%;
            height: 40px;
            margin-left: 8px;
            color: white;
            background-color: rgb(204, 2, 2);
            border-color:  rgb(204, 2, 2);
            border-radius: 6px;
        }
    </style>

    <style>
        .containerr {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 70px;
            background-color: #f0f0f0;
            padding: 40px;
            border-radius: 10px;
            margin-top: 30px;
        }

        .icon-container {
            text-align: center;
            position: relative;
            display: inline-block;
        }

        .icon-container a {
            text-decoration: none;
            color: #333;
        }

        .icon-container img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 2px solid #333;
            padding: 5px;
            transition: opacity 0.3s;
        }

        .icon-text {
            font-size: 14px;
            margin-top: 10px;
        }

        .icon-container a::before {
            content: attr(data-title); 
            background-color: #001F54;
            color: #FFF;
            padding: 10px;
            width: 250px;
            text-align: center;
            position: absolute;
            top: -60px;
            left: 50%;
            transform: translateX(-50%) scale(0);
            opacity: 0;
            visibility: hidden;
            transition: transform 0.3s ease, opacity 0.3s ease, visibility 0.3s ease, width 0.3s ease, height 0.3s ease;
            z-index: 1;
            border-radius: 5%;
        }

        .icon-container a:hover::before {
            transform: translateX(-50%) scale(1);
            opacity: 1;
            visibility: visible;
        }
    </style>

  </head>
<body

  <!--LOADER-->
  <script src="js/loader.js"></script>
  <div class="loader"></div>

  <div class="sidebar close">
    <div class="logo-details">
      <span class="logo_name">DORA</span>
    </div>
    <ul class="nav-links">
        <li>
          <a href="socialworker_home.php">
            <i class='bx bx-home' ></i>
            <span class="link_name">Home</span>
          </a>

          
          <!-- DONATIONS -->
        <li>
          <div class="iocn-link">
            <a href="current_donation.php">
              <i class='bx bx-collection' ></i>
              <span class="link_name">Donation</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="current_donation.php">Donation</a></li>
            <li><a href="upload_donation.php">Upload Donation Drive</a></li>
            <li><a href="donation_analytics.php">Donation Analytics</a></li>
          </ul>
        </li>
        <!-- VOLUNTEERS -->
        <li>
          <div class="iocn-link">
            <a href="current_volunteer.php">
              <i class='bx bx-book-alt' ></i>
              <span class="link_name">Volunteer</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="current_volunteer.php">Volunteer</a></li>
            <li><a href="upload_volunteer.php">Upload Volunteer</a></li>
            <li><a href="volunteer_analytics.php">Volunteer Analytics </a></li>
          </ul>
        </li>
        <!-- ASSISTANCE -->
        <li>
          <div class="iocn-link">
            <a href="assistance.php">
            <i class='bx bx-compass' ></i>
              <span class="link_name">Assistance</span>
            </a>
            <i class='bx bxs-chevron-down arrow' ></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="assistance.php">Assistance</a></li>
            <li><a href="upload_assistance.php">Upload Assistance</a></li>
            <li><a href="assistance_analytics.php">Assistance Analytics</a></li>
          </ul>
        </li>

        
        <li>
        <form method="post" action="\Views\SocialWorker\socialworker_home.php">
          <a href="/login.php" onclick="document.querySelector('button[name=\'end\']').click();">
            <i class='bx bx-log-out'></i>
            <input type="hidden" name="end" value="true">
            <span class="link_name">Logout</span>
          </a>
          <button type="submit" name="end" style="display: none;"></button>
        </form>
      </li>


        <li>
        <div class="profile-details">
        <div class="profile-content">
          <?php
            $select = mysqli_query($conn, "SELECT * FROM `tbl_sw_accs` WHERE sw_id = '$sw_id'") or die('query failed');
            if(mysqli_num_rows($select) > 0){
                $fetch = mysqli_fetch_assoc($select);
            }
            if($fetch['image'] == ''){
                echo '<img src="images/default-avatar.png">';
            }else{
                echo '<img src="/uploaded_img/'.$fetch['image'].'">';
            }
            
            $fullName = $fetch['fname'] . ' ' . $fetch['lname'];
            $welcomeMessage = "Welcome Social Worker, " . $fullName . "!";
          ?>
        </div>
  </div>
  </li>
  </ul>
  </div>
  
  <!-- TITLE BARS -->
  <div class="header">
        <h3>HOME</h3>
  </div>

  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu'></i>
       <span class="text"><?php echo $welcomeMessage; ?></span>
    </div>

      <div class="text-center" id="current-time"></div>
      <script>
        function updateCurrentTime() {
          const now = new Date();
          const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true,
          };
          const currentTimeString = now.toLocaleString('en-US', options);
          document.getElementById('current-time').textContent = currentTimeString;
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);
      </script>
    </div><br>

    <!-- Menu -->
    <div class="containerr">
      <!-- New Donation Project -->
      <div class="icon-container">
          <a href="upload_donation.php" data-title="New Donations Project">
              <img src="/img/sw-icons/add-don.png" alt="New Donate Image">
              <p class="icon-text">Donate</p>
          </a>
      </div>

      <!-- New Volunteering Project -->
      <div class="icon-container">
          <a href="upload_volunteer.php" data-title="New Volunteering Project">
              <img src="/img/sw-icons/add-vol.png" alt="New Volunteer Image">
              <p class="icon-text">Volunteer</p>
          </a>
      </div>

      <!-- New Assistance Project -->
      <div class="icon-container">
          <a href="upload_assistance.php" data-title="New Assistance Project">
              <img src="/img/sw-icons/add-assist.png" alt="New Assistance Image">
              <p class="icon-text">Assist</p>
          </a>
      </div>

      <!-- View Donation Projects -->
      <div class="icon-container">
          <a href="current_donation.php" data-title="View Donation Projects">
              <img src="/img/sw-icons/view-don.png" alt="View Donation Image">
              <p class="icon-text">Donations</p>
          </a>
      </div>

      <!-- View Volunteering Projects -->
      <div class="icon-container">
          <a href="current_volunteer.php" data-title="View Volunteering Projects">
              <img src="/img/sw-icons/view-vol.png" alt="View Volunteering Project">
              <p class="icon-text">Volunteers</p>
          </a>
      </div>

      <!-- View Assistance Projects -->
      <div class="icon-container">
          <a href="assistance.php" data-title="View Assistance Projects">
              <img src="/img/sw-icons/view-assist.png" alt="View Assistance Project">
              <p class="icon-text">Assistance</p>
          </a>
      </div>
  </div>

    <!-- Profile View of Social Worker-->
        

    <div class="container">
    <div class="row">
      <!-- SOCIAL WORKER ON GOING DONATION DRIVES COUNT -->
        <?php
          $sql = "SELECT COUNT(*) as donproj_count 
          FROM tbl_don_proj 
          WHERE tbl_don_proj.sw_id = $sw_id 
          AND proj_stat = 'ON GOING'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo'<div class="col-sm-4 mb-3"><br>
                  <div class="card-body">';
                  echo '<div class="card align-items-center"><br>';
                  echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["donproj_count"] .  '</p>';
                  echo '<p style="color:#6C757D; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Donation Drives</p>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
              }
          } else {
              echo "0 results";
          }
          ?>

    <!-- SOCIAL WORKER VOLUNTEER PROJECT COUNT -->
    <?php
          $sql = "SELECT COUNT(*) as volproj_count 
          FROM tbl_vol_proj 
          WHERE tbl_vol_proj.sw_id = $sw_id 
          AND proj_stat = 'ON GOING'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo'<div class="col-sm-4 mb-3"><br>
                  <div class="card-body">';
                  echo '<div class="card align-items-center"><br>';
                  echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["volproj_count"] .  '</p>';
                  echo '<p style="color:#6C757D; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Volunteering Projects</p>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
              }
          } else {
              echo "0 results";
          }
          ?>

    <!-- SOCIAL WORKER ASSISTANCE PROJECT COUNT -->
    <?php
          $sql = "SELECT COUNT(*) as assistproj_count 
          FROM tbl_assistance 
          WHERE tbl_assistance.sw_id = $sw_id 
          AND proj_stat = 'ON GOING'";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
                echo'<div class="col-sm-4 mb-3"><br>
                  <div class="card-body">';
                  echo '<div class="card align-items-center"><br>';
                  echo '<p style="font-size: 30px; color: #001F54; margin-bottom: -5px; font-weight: 600;">' . $row["assistproj_count"] .  '</p>';  
                  echo '<p style="color:#6C757D; font-size: 15px;" class="d-flex align-items-center mb-3">On Going Assistance Projects</p>';
                  echo '</div>';
                  echo '</div>';
                  echo '</div>';
              }
          } else {
              echo "0 results";
          }
          ?>
      </div>
    </div>
    <?php 

$sql = "SELECT *, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name FROM tbl_sw_accs where tbl_sw_accs.sw_id = $sw_id ";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($result)){
    echo'
    <div class="container">
    <div class="main-body">

<div class="row gutters-sm">
<div class="col-md-4 mb-3">
  <div class="card">
    <div class="card-body">
      <div class="d-flex flex-column align-items-center text-center"><br><br>
      <img src="/uploaded_img/'.$row['image'].'"height="150px"><br>
      <div class="mt-3">
          <h4>'.$row['name'].'</h4>
          <p class="text-secondary mb-3">Social Worker Account</p><br><br>
        </div>
      </div>
    </div>
  </div>
  <div class="">
     
    </ul>
  </div>
</div>
<div class="col-md-8">
  <div class="card mb-3">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Full Name</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['full_name'].' 
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Email</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['email'].'
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Phone</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['full_contact'].'
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Street</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['street'].'
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Barangay</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['brgy'].'
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">Municipality</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['municipality'].'
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-sm-3">
          <h6 class="mb-0">City/Province</h6>
        </div>
        <div class="col-sm-9 text-secondary">
        '.$row['city'].'
        </div>
      </div>
      </div>
    </div>
    
  </div>


  ';}?>

  <br><br>


  
  <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
   arrowParent.classList.toggle("showMenu");
    });
  }
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
  console.log(sidebarBtn);
  sidebarBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("close");
  });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
