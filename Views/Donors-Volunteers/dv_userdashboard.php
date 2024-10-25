<?php include 'includes/config.php';?>

<?php
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:/login.php');
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:/index.php');
}

if (isset($_POST['saveButton'])) {
    $newFname = $_POST['edit_fname'];
    $newMname = $_POST['edit_mname'];
    $newLname = $_POST['edit_lname'];
    $newEmail = $_POST['edit_email'];
    $newContact = $_POST['edit_contact'];
    $newAge = $_POST['edit_age'];
    $newGender = $_POST['edit_gender'];
    $newCity = $_POST['edit_city'];
    $newMun = $_POST['edit_mun'];
    $newBrgy = $_POST['edit_brgy'];
    $newStreet = $_POST['edit_street'];

    // Update the user's profile information in the database
    $updateQuery = "UPDATE tbl_dv_accs SET fname=?, mname=?, lname=?, email=?, full_contact=?, birthday=?, gender=?, city=?, municipality=?, brgy=?, street=? WHERE user_id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssssssi", $newFname, $newMname, $newLname, $newEmail, $newContact, $newAge, $newGender, $newCity, $newMun, $newBrgy, $newStreet, $user_id);
    $stmt->execute();

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Donor/Volunteer</title>
    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/donation_transaction.css"> 
    <link rel="stylesheet" href="css/edit_prof.css"> 

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- CDN LINK -->
     <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

  <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    
    
    
    <link rel="manifest" href="/img/icon/site.webmanifest">
    <style>
        .container-profile {
            border: 2px solid #001F54;
            padding: 20px;
        }

        .container-profile table {
            width: 100%;
            overflow-x: auto;
        }
        #card-top{
            padding-top: 20px;
            margin-bottom: -110px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .card1 {

            text-align: center;
            padding: 20px;
            border: 2px solid #001F54;
            border-radius: 5px;
            height: 82%;
        }
        
        .card-body1{
            padding-bottom: 180px;
        }
        
        .card {

            text-align: center;
            padding: 20px;
            border: 2px solid #001F54;
            border-radius: 5px;
            height: 80%;
        }
        
        .card-body{
            padding-bottom: 180px;
        }
        
        .tab-title {
            background-color: #001F54;
            color: #fff;
            padding: 10px 15px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            font-size: 20px;
            margin-bottom: 15px;
            text-align: center; 
        }

        .tab-label {
            display: flex;
            align-items: center;
            justify-content: center; 
        }
        .card-body,
        .col-sm-9.text-secondary {
            text-align: left;
        }
        
        .col-sm-9.text-secondary {
            margin-top: 0;
        }

        a {
            text-decoration: none; /* Remove underline */
            color: inherit; /* Change link color to inherit from parent */
        }

        /* Apply hover effect to table row */
        tr:hover {
            background-color: #f0f0f0; /* Change background color on hover */
            /* Add other styles for hover effect */
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
                            <a class="nav-link active" href="dv_userdashboard.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                '?>
            </div>
        </div>
    </nav>

<!-- USER PROFILE -->
    <?php 
            $sql = "SELECT *, CONCAT(fname, ' ', COALESCE(mname, ''), ' ', lname) AS full_name,
            CONCAT(fname, ' ', ' ', lname) AS name,
            CONCAT(street, ', ', brgy, ', ', municipality, ', ', city) AS address
            FROM tbl_dv_accs where tbl_dv_accs.user_id = $user_id";
            $result = mysqli_query($conn, $sql);
            

            while ($row = mysqli_fetch_array($result)){

                echo'
                <div class="container">
                <div class="main-body">

            <div class="row gutters-sm" id="card-top">
                <div class="col-md-4 mb-3">
                    <div class="card1" id="card1-container">
                        <div class="card-body1">
                            <div class="d-flex flex-column align-items-center text-center">
                                <img src="/uploaded_img/'.$row['image'].'" height="150px"><br>
                                <div class="mt-3">
                                    <h4>'.$row['name'].'</h4>
                                    <p class="text-secondary mb-1">Donor/Volunteer Account</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
            <div class="card mb-3" id="card-container">
                <div class="card-body"  style="height: 170px;">
                    <form method="post" id="profileForm">
                    
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0" id="label_fname">First Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <span id="fname">' . $row['fname'] . '</span>
                                <input type="text" id="edit_fname" name="edit_fname" value="' . $row['fname'] . '" 
                                style="display: none; width: 300px; height: 25px; font-size: 13px; 14px; margin-top: -17px;"><br>
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0" id="label_mname">Middle Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <span id="mname">' . $row['mname'] . '</span>
                                <input type="text" id="edit_mname" name="edit_mname" value="' . $row['mname'] . '
                                " style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                            </div>
                        </div>
                        
                         <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0" id="label_lname">Last Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <span id="lname">' . $row['lname'] . '</span>
                                <input type="text" id="edit_lname" name="edit_lname" value="' . $row['lname'] . '" 
                                style="display: none; width: 300px; height: 25px; font-size: 13px; 14px; margin-top: -17px;"><br>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0" id="label_num">Contact Number</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <span id="contact">' . $row['full_contact'] . '</span>
                            <input type="text" id="edit_contact" name="edit_contact" value="' . $row['full_contact'] . '" 
                            style="display: none; width: 300px; height: 25px; font-size: 14px; 13px; margin-top: -17px;"><br>
                        </div>
                    </div>

                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0" id="label_email">Email Address</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <span id="email">' . $row['email'] . '</span>
                            <input type="text" id="edit_email" name="edit_email" value="' . $row['email'] . '" 
                            style="display: none; width: 300px; height: 25px; font-size: 13px;  margin-top: -17px;"><br>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0" id="label_bday">Birthday</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <span id="age">' . $row['birthday'] . '</span>
                            <input type="date" id="edit_age" name="edit_age" value="' . $row['birthday'] . '" 
                            style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                        </div>
                    </div>

                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0" id="label_gender">Gender</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                        <span id="gender">' . $row['gender'] . '</span>
                        <input type="text" id="edit_gender" name="edit_gender" value="' . $row['gender'] . '" 
                        style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                    </div>
                </div>
                
                <div class="row">
                   <div class="col-sm-3">
                       <h6 class="mb-0" id="label_city">City</h6>
                   </div>
                   <div class="col-sm-9 text-secondary">
                       <span id="city">' . $row['city'] . '</span>
                       <input type="text" id="edit_city" name="edit_city" value="' . $row['city'] . '" 
                       style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                   </div>
                </div>
                
                
                <div class="row">
                   <div class="col-sm-3">
                       <h6 class="mb-0" id="label_mun">Municipality</h6>
                   </div>
                   <div class="col-sm-9 text-secondary">
                       <span id="municipality">' . $row['municipality'] . '</span>
                       <input type="text" id="edit_mun" name="edit_mun" value="' . $row['municipality'] . '" 
                       style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                   </div>
                </div>
                
                <div class="row">
                   <div class="col-sm-3">
                       <h6 class="mb-0" id="label_brgy">Barangay</h6>
                   </div>
                   <div class="col-sm-9 text-secondary">
                       <span id="brgy">' . $row['brgy'] . '</span>
                       <input type="text" id="edit_brgy" name="edit_brgy" value="' . $row['brgy'] . '" 
                       style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                   </div>
                </div>
                
                <div class="row">
                   <div class="col-sm-3">
                       <h6 class="mb-0" id="label_st">Street</h6>
                   </div>
                   <div class="col-sm-9 text-secondary">
                       <span id="street">' . $row['street'] . '</span>
                       <input type="text" id="edit_street" name="edit_street" value="' . $row['street'] . '" 
                       style="display: none; width: 300px; height: 25px; font-size: 13px; margin-top: -17px;"><br>
                   </div>
                </div>



            </div>
            <br>
            <br>
                     <br>
                     <br>
                <button type="button" class="btn btn-primary" id="editButton" onclick="enableEditMode()">Edit Profile</button>
                <button type="submit" class="btn btn-success" id="saveButton" name="saveButton" style="display: none;">Save Profile</button>
            
            </form>
        </div>
    </div>
</div>
                  ';}?>

                    <div class="card-container">
                      <!-- DONATION CARD -->
                      <?php

                      $sql = "SELECT SUM(amount) as sum FROM tbl_transaction WHERE tbl_transaction.user_id = $user_id AND stat = 'Verified'";
                      $result = $conn->query($sql);
                      if ($result->num_rows > 0) {
                          while($row = $result->fetch_assoc()) {
                              echo '<div class="card align-items-center my-4"><br>';
                              echo '<h6 style="color:blue" class="d-flex align-items-center mb-3">Total Amount of Donations Made</h6>';
                              echo '<p>' . number_format($row["sum"]). '</p>';
                              echo '</div>';
                          }
                      } else {
                          echo "0 results";
                      }
                      ?>

                  <!-- VOLUNTEER CARD 1 -->
                  <?php

                  $sql = "SELECT COUNT(DISTINCT vol_proj_id) AS pending_count FROM tbl_volunteers WHERE user_id = '$user_id' AND stat = 'Pending'";                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo '<div class="card align-items-center my-4"><br>';
                          echo '<h6 style="color:orange" class="d-flex align-items-center mb-3">Pending Volunteer Applications</h6>';
                          echo '<p>' . $row["pending_count"] .  '</p>';
                          echo '</div>';
                      }
                  } else {
                      echo "0 results";
                  }
                  ?>

                  <!-- VOLUNTEER CARD 2 -->
                  <?php
                  if ($conn->connect_error) {
                      die("Connection failed: " . $conn->connect_error);
                  }
                  $sql = "SELECT COUNT(DISTINCT vol_proj_id) AS verified_count FROM tbl_volunteers WHERE user_id = '$user_id' AND stat = 'Verified'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo '<div class="card align-items-center my-4"><br>';
                          echo '<h6 style="color:green" class="d-flex align-items-center mb-3">Verified Volunteer Applications</h6>';
                          echo '<p>'. $row["verified_count"] . '</p>';
                          echo '</div>';
                      }
                  } else {
                      echo "0 results";
                  }
                  ?>

                   <!-- VOLUNTEER CARD 3 -->
                    <?php

                        $sql = "SELECT COUNT(DISTINCT vol_proj_id) AS invalid_count FROM tbl_volunteers WHERE user_id = '$user_id' AND stat = 'Invalid'";                  $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<div class="card align-items-center my-4"><br>';
                                echo '<h6 style="color:red" class="d-flex align-items-center mb-3">Invalid Volunteer Applications</h6>';
                                echo '<p>'. $row["invalid_count"] . '</p>';
                                echo '</div>';
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                  </div>



  <article class="article">
    <div class="tabs">
        <label for="tab1" class="tab-label">
            <span class="tab-title">My Donation Transaction History</span>
        </label>

        <div id="tab__content--1" class="tab__content">
            <div class="container-profile table">
                  

        <!-- USER DONATION HISTORY TAB -->
       <div id="tab__content--1" class="tab__content">
       <div class="container table">
            
                    <!-- ALL TABS -->
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                        <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Project Title</th>
                              <th scope="col">Date Submitted</th>
                              <th scope="col">Amount</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                      
                          <?php
                              $sql4 = "SELECT DISTINCT *
                              FROM tbl_transaction t
                              INNER JOIN tbl_dv_accs d ON t.user_id = d.user_id
                              LEFT JOIN tbl_don_proj p ON t.don_project_id = p.don_project_id
                              WHERE t.user_id = $user_id
                              ORDER BY t.submitdate DESC";


                            $result2 = mysqli_query($conn, $sql4);
                            while ($row = mysqli_fetch_array($result2)){
                                echo '
                                    <tr>
                                        <td><a href="/Views/Donors-Volunteers/donation_projects.php?id='.$row['don_project_id'].'">' . $row['title'] . '</a></td>
                                        <td>'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                        <td>&#8369;'.$row['amount'].'</td>
                                        <td>';
                                        if ($row['stat'] == 'Verified') {
                                          echo '<p style="color: green">'.$row['stat'].'</p>';
                                      } elseif ($row['stat'] == 'Pending') {
                                          echo '<p style="color: orange">'.$row['stat'].'</p>';
                                      } elseif ($row['stat'] == 'Invalid') {
                                          echo '<p style="color: red">'.$row['stat'].'</p>';
                                      }
                                echo '</td>
                                    <td><a href="/Views/Donors-Volunteers/don_trans_details.php?id='.$row['id'].'&transac_id='.$row['transac_id'].'"><button type="button" class="btn btn-outline-primary">Details</button></a></td>
                                    </tr>
                              ';
                            }
                          ?>

                          </tbody>
                        </table>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>


<article class="article">
    <div class="tabs">
        <label for="tab1" class="tab-label">
            <span class="tab-title">My Volunteering History</span>
        </label>

        <div id="tab__content--1" class="tab__content">
            <div class="container-profile table">
                   

      <!-- USER VOLUNTEER HISTORY TAB -->
        <div id="tab__content--2" class="tab__content">
            <div class="container table">
                <!-- ALL TABS -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="every-tab-pane" role="tabpanel" aria-labelledby="every-tab" tabindex="0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Project Title</th>
                                    <th scope="col">Date Submitted</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">E-ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT *
                                        FROM tbl_volunteers t
                                        INNER JOIN tbl_dv_accs d ON t.user_id = d.user_id
                                        LEFT JOIN tbl_vol_proj p ON t.vol_proj_id = p.vol_proj_id
                                        WHERE t.user_id = $user_id
                                        GROUP BY t.vol_proj_id
                                        ORDER BY t.submitteddate DESC";
        
                                $result = mysqli_query($conn, $sql);
        
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tr>
                                         
                                            <td><a href="/Views/Donors-Volunteers/vol_projects.php?id='.$row['vol_proj_id'].'">' . $row['title'] . '</a></td>
                                            <td>'.date('F j, Y', strtotime($row['submitteddate'])).'</td>
                                            <td>' . $row['location'] . '</td>
                                            <td>';
                                    if ($row['stat'] == 'Verified') {
                                        echo '<p style="color: green">' . $row['stat'] . '</p>';
                                    } elseif ($row['stat'] == 'Pending') {
                                        echo '<p style="color: orange">' . $row['stat'] . '</p>';
                                    } elseif ($row['stat'] == 'Invalid') {
                                        echo '<p style="color: red">' . $row['stat'] . '</p>';
                                    }
                                    echo '</td>';
        
                                    // Check if the status is 'Verified' before displaying the button
                                    if ($row['stat'] == 'Verified') {
                                        echo '<td><a href="electronic_id.php?volunteer_id=' . $row['volunteer_id'] . '&id=' . $row['vol_proj_id'] . '"><button type="button" class="btn btn-outline-primary">View</button></a></td>';
                                    } else {
                                        echo '<td>No Electronic ID Available</td>';
                                    }
        
                                    echo '</tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>

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
    
    
      function enableEditMode() {
            document.getElementById("editButton").style.display = "none";
            document.getElementById("saveButton").style.display = "block";
    
            document.getElementById("fname").style.display = "none";
            document.getElementById("edit_fname").style.display = "block";
            
            document.getElementById("mname").style.display = "none";
            document.getElementById("edit_mname").style.display = "block";
            
            document.getElementById("lname").style.display = "none";
            document.getElementById("edit_lname").style.display = "block";
            
            document.getElementById("contact").style.display = "none";
            document.getElementById("edit_contact").style.display = "block";
    
            document.getElementById("email").style.display = "none";
            document.getElementById("edit_email").style.display = "block";
            
            document.getElementById("age").style.display = "none";
            document.getElementById("edit_age").style.display = "block";
    
            document.getElementById("gender").style.display = "none";
            document.getElementById("edit_gender").style.display = "block";
            
            document.getElementById("city").style.display = "none";
            document.getElementById("edit_city").style.display = "block";
            
            document.getElementById("municipality").style.display = "none";
            document.getElementById("edit_mun").style.display = "block";
            
            document.getElementById("brgy").style.display = "none";
            document.getElementById("edit_brgy").style.display = "block";
            
            document.getElementById("street").style.display = "none";
            document.getElementById("edit_street").style.display = "block";
            
            document.getElementById('label_fname').style.marginTop = '-17px';
            document.getElementById('label_mname').style.marginTop = '-17px';
            document.getElementById('label_lname').style.marginTop = '-17px';
            document.getElementById('label_num').style.marginTop = '-17px';
            document.getElementById('label_email').style.marginTop = '-17px';
            document.getElementById('label_bday').style.marginTop = '-17px';
            document.getElementById('label_gender').style.marginTop = '-17px';
            document.getElementById('label_city').style.marginTop = '-17px';
            document.getElementById('label_mun').style.marginTop = '-17px';
            document.getElementById('label_brgy').style.marginTop = '-17px';
            document.getElementById('label_st').style.marginTop = '-17px';
            document.getElementById('saveButton').style.marginTop = '61px';
            document.getElementById('card-top').style.marginBottom = '-75px';
            document.getElementById('card-container').style.height = '86%';
            document.getElementById('card1-container').style.height = '89%';
            
 
            
        }
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>