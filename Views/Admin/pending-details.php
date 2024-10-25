<?php

include 'includes/config.php';
session_start();
$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($admin_id);
   session_destroy();
   header('location:/login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Account Details</title>

   <link rel="stylesheet" href="css/sidebar.css">
   <link rel="stylesheet" href="css/dn-fullproject.css">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

      <!--ICONS-->
      <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">


 <style>

        .nav-links li a:hover::before {
            content: attr(data-title);
            position: absolute;
            background: #034078;
            color: #fff;
            border-radius: 5px;
            padding: 10%;
            margin-left: -10px;
            z-index: 1;
            top: 50%;
            left: 110%;
            transform: translateY(-50%);
            white-space: nowrap;
        }
        
        .nav-links li a {
            text-decoration: none;
        }

    </style>
</head>
<body>
 <!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>

    <!-- SIDEBAR -->
   <div class="sidebar close no-print">
    <div class="logo-details">
        <span class="logo_name"></span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="admin_home.php" data-title="Home">
                <i class='bx bx-home'></i>
                <span class="link_name">Home</span>
            </a>
        </li>
        <li>
            <a href="dora_projects.php" data-title="Pending Projects">
                <i class='bx bx-news'></i>
                <span class="link_name">Projects</span>
            </a>
        </li>
        <li>
            <a href="donation-funds.php" data-title="Donation Funds">
                <i class='bx bxs-receipt'></i>
                <span class="link_name">Donation Funds</span>
            </a>
        </li>
        <!-- ADMINS -->
        <li>
            <a href="donation-analytics.php" data-title="Donation Analytics">
                <i class='bx bx-money'></i>
                <span class="link_name">Donation Analytics</span>
            </a>
        </li>
        <li>
            <a href="volunteer-analytics.php" data-title="Volunteer Analytics">
                <i class='bx bx-group'></i>
                <span class="link_name">Volunteer Analytics</span>
            </a>
        </li>
        <li>
            <a href="assistance-analytics.php" data-title="Assistance Analytics">
                <i class='bx bx-donate-heart'></i>
                <span class="link_name">Assistance Analytics</span>
            </a>
        </li>
        <li>
            <a href="sw-analytics.php" data-title="Social Worker Analytics">
                <i class='bx bx-bar-chart-alt'></i>
                <span class="link_name">Social Worker Analytics</span>
            </a>
        </li>
        <li>
            <div class="iocn-link">
                <a href="socialworkers.php" data-title="Social Workers">
                    <i class='bx bxs-user-detail'></i>
                    <span class="link_name">Social Workers</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="pending-accs.php" data-title="Pending Accounts">
                    <i class='bx bxs-user-plus'></i>
                    <span class="link_name">Pending Accounts</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="sw-activity.php" data-title="Workers Activity">
                    <i class='bx bx-time'></i>
                    <span class="link_name">Workers Activity</span>
                </a>
            </div>
        </li>
        <li>
            <div class="iocn-link">
                <a href="logout.php" data-title="Logout">
                    <i class='bx bx-log-out'></i>
                    <span class="link_name">Logout</span>
                </a>
            </div>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM tbl_admin_accs WHERE admin_id = '$admin_id'")
                        or die('query failed');
                    if (mysqli_num_rows($select) > 0) {
                        $fetch = mysqli_fetch_assoc($select);
                    }
                    if ($fetch['image'] == '') {
                        echo '<img src="images/default-avatar.png">';
                    } else {
                        echo '<img src="/uploaded_img/' . $fetch['image'] . '">';
                    }
                    ?>
                </div>
            </div>
        </li>
    </ul>
</div>

  <!-- TITLE BARS -->
  <div class="header">
        <h5>Pending Account Details</h5>
  </div>

  <section class="home-section">

    <div class="wrapper"> 

        <div class="back-btn">
        <button type="button" class="btn" onclick="goBack()">Back</button>
        </div>

    <?php
    
            $sw_id = $_GET['sw_id']; 
            $sql = "SELECT *, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name FROM tbl_sw_accs WHERE sw_id = $sw_id";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($result)){
                echo'
                <form method="POST" action="update-sw.php">
                <div class="container">
                <div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body" style="border: 2px solid #000000;">
                  <div class="d-flex flex-column align-items-center text-center"><br><br>
                  <img src="/uploaded_img/'.$row['image'].'"height="150px"><br>
                  <div class="mt-3">
                      <h4>'.$row['full_name'].'</h4>
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
                <div class="card-body" style="border: 2px solid #000000;">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['full_name'].' 
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['email'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['full_contact'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Street</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['street'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Barangay</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['brgy'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Municipality</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['municipality'].'
                    </div></b>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">City/Province</h6>
                    </div>
                    <div class="col-sm-9 text-secondary"><b>
                    '.$row['city'].'
                    </div></b>
                  </div>
                  </div>
                  </div>
                </div>';}?>
                </form>
                
       
              <div style="text-align: center;">
                    <form method="POST" action="update-sw.php">
                       <input type="hidden" name="sw_id" value="' . $sw_id . '">
  
                       <button type="button" class="btn btn-success" onclick="showVerifyConfirmation()">Verify</button>
                       <button type="button" class="btn btn-danger" onclick="showInvalidConfirmation()">Invalid</button>
                       </form>
                       </div>
      
             


      <!-- Verify Modal -->
    <div class="modal fade" id="verifyModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalLabel" aria-hidden="true">
        <!-- Modal content here -->
        <form method="POST" action="update-sw.php">
            <input type="hidden" name="sw_id" value="<?php echo $sw_id; ?>">
            <button type="submit" class="btn btn-success">Confirm Verify</button>
        </form>
    </div>

    <!-- Invalid Modal -->
    <div class="modal fade" id="invalidModal" tabindex="-1" role="dialog" aria-labelledby="invalidModalLabel" aria-hidden="true">
        <!-- Modal content here -->
        <form method="POST" action="update-sw.php">
            <input type="hidden" name="sw_id" value="<?php echo $sw_id; ?>">
            <button type="submit" class="btn btn-danger">Confirm Invalid</button>
        </form>
    </div>
    
    <?php
$sql = "SELECT * FROM tbl_sw_accs WHERE sw_id = $sw_id ";
$result = mysqli_query($conn, $sql);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        echo '
        <div class="col-4 mx-auto">
            <div class="box text-center" style="margin-top: 10px;">';

        // Check if the status is neither 'Verified' nor 'Invalid'
        if ($row['status'] !== 'Verified' && $row['status'] !== 'Invalid') {
            echo '
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal">
                    View Valid ID
                </button>';
        }

        echo '
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class "modal-title" id="exampleModalLabel">Social Worker ' . $row['idtype'] . ' </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img src="/uploaded_valid_id/' . $row['valid_image'] . '" style="max-width: 100%; height: auto">
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>';
    } else {
        echo "No data found for the specified sw_id.";
    }
} else {
    echo "Error in the SQL query: " . mysqli_error($conn);
}

?>

<script>
   function showVerifyConfirmation() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to verify this account?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, verify!'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm('verify');
        }
    });
}

function showInvalidConfirmation() {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Are you sure you want to mark this account as invalid?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, mark as invalid!'
    }).then((result) => {
        if (result.isConfirmed) {
            submitForm('invalid');
        }
    });
}


    function submitForm(action) {
        var form = document.createElement('form');
        form.setAttribute('method', 'POST');
        form.setAttribute('action', 'update-sw.php');

        var swIdInput = document.createElement('input');
        swIdInput.setAttribute('type', 'hidden');
        swIdInput.setAttribute('name', 'sw_id');
        swIdInput.setAttribute('value', '<?php echo $sw_id; ?>');

        var actionInput = document.createElement('input');
        actionInput.setAttribute('type', 'hidden');
        actionInput.setAttribute('name', action);
        actionInput.setAttribute('value', 'true');

        form.appendChild(swIdInput);
        form.appendChild(actionInput);

        document.body.appendChild(form);

        form.submit();
    }
</script>

  <script>
    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", (e)=>{
    let arrowParent = e.target.parentElement.parentElement;
    arrowParent.classList.toggle("showMenu");
      });
    }
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".bx-menu");
    console.log(sidebarBtn);
    sidebarBtn.addEventListener("click", ()=>{
      sidebar.classList.toggle("close");
    });


    function goBack() {
            window.history.back();
        }
  </script>

<script>
  function confirmEmail() {
    Swal.fire({
      title: "Email Sent Successfully",
      text: "The email has been sent successfully.",
      icon: "success",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "pending-accs.php"; 
      }
    });
  }
</script>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>