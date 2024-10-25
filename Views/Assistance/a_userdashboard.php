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
   header('location:/login.php');
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
    $updateQuery = "UPDATE tbl_appli_accs SET fname=?, mname=?, lname=?, email=?, full_contact=?, birthday=?, gender=?, city=?, municipality=?, brgy=?, street=? WHERE appli_id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssssssi", $newFname, $newMname, $newLname, $newEmail, $newContact, $newAge, $newGender, $newCity, $newMun, $newBrgy, $newStreet, $appli_id);
    $stmt->execute();

}
  

  
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Assistance Applicant</title>
    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/donation_transaction.css">

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

    </head>
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
            margin-bottom: -120px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        .card {

            text-align: center;
            padding: 20px;
            border: 2px solid #001F54;
            border-radius: 5px;
        }
        .card-body{
            padding-bottom: 180px;
        }
        
        .card1 {

            text-align: center;
            padding: 20px;
            border: 2px solid #001F54;
            border-radius: 5px;
            height: 78%;
        }
        
        .card-body1{
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
        .btn_delete{
            position: left;
            width: 100%;
            height: 40px;
            color: white;
            background-color: red;
            border-radius: 6px;
            margin-top: 5px;
            border-color: red;
        }
        .btn_delete:hover{
            position: left;
            width: 100%;
            height: 40px;
            color: white;
            background-color: rgb(204, 2, 2);
            border-color:  rgb(204, 2, 2);
            border-radius: 6px;
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
    <style>
  .id-card-container {
    text-align: left; /* Align the content to the left */
  }

  .id-card-container .qr-code {
    margin-right: auto; /* Align the QR code to the left by pushing it to the right */
    display: block; /* Make sure it's a block element to respect the margin properties */
  }
</style>


<body>

<!--NAV BAR-->
<nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="assistance_index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30" ></a>
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
                            <a class="nav-link" href="assistance.php">Assistance</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="a_userdashboard.php">Profile</a>
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
            CONCAT(fname, ' ', ' ', lname) AS name
            FROM tbl_appli_accs where tbl_appli_accs.appli_id = $appli_id";
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
                                    <p class="text-secondary mb-1">Assistance Applicant Account</p>
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

                <!-- ASSISTANCE CARD 1 -->
                <?php
                  $sql = "SELECT COUNT(DISTINCT appli_id) as pending_count FROM tbl_applicants WHERE tbl_applicants.appli_id = $appli_id AND stat = 'Pending'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo '<div class="card align-items-center my-4"><br>'; // Added my-4 class for margin
                          echo '<h6 style="color: orange" class="d-flex align-items-center mb-3">Pending Assistance Applications</h6>';
                          echo '<p>' . $row["pending_count"] .  '</p>';
                          echo '</div>';
                      }
                  } else {
                      echo "0 results";
                  }
                  ?>

                  <!-- ASSISTANCE CARD 2 -->
                <?php
                  $sql = "SELECT COUNT(DISTINCT appli_id) as verified_count FROM tbl_applicants WHERE tbl_applicants.appli_id = $appli_id AND stat = 'Verified'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo '<div class="card align-items-center my-4"><br>';
                          echo '<h6 style="color: green" class="d-flex align-items-center mb-3">Verified Applications</h6>';
                          echo '<p>' . $row["verified_count"] . '</p>';
                          echo '</div>';
                      }
                  } else {
                      echo "0 results";
                  }
                  ?>

                  <!-- ASSISTANCE CARD 3 -->
                <?php
                  $sql = "SELECT COUNT(DISTINCT appli_id) as invalid_count FROM tbl_applicants WHERE tbl_applicants.appli_id = $appli_id AND stat = 'Invalid'";
                  $result = $conn->query($sql);
                  if ($result->num_rows > 0) {
                      while($row = $result->fetch_assoc()) {
                          echo '<div class="card align-items-center my-4"><br>';
                          echo '<h6 style="color: red" class="d-flex align-items-center mb-3">Invalid Applications</h6>';
                          echo '<p>' . $row["invalid_count"] . '</p>';
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
            <span class="tab-title">My Assistance Application History</span>
        </label>

        <div id="tab__content--1" class="tab__content">
            <div class="container-profile table">
                <!-- ALL TABS -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                        <table class="table">
                            <thead>
                                <tr>
                                
                                    <th scope="col">Project Title</th>
                                    <th scope="col">Date Submitted</th>
                                    <th scope="col">Location</th>
                                    <th scope="col">Application Status</th>
                                    <th scope="col">QR Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                $sql = "SELECT *
                                    FROM tbl_applicants t
                                    INNER JOIN tbl_appli_accs d ON t.appli_id = d.appli_id
                                    LEFT JOIN tbl_assistance p ON t.assistance_id = p.assistance_id
                                    WHERE t.appli_id = $appli_id
                                    GROUP BY t.assistance_id
                                    ORDER BY t.submitteddate DESC";

                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<tr>';
                                    echo '<td><a href="/Views/Assistance/assistance_projects.php?id='.$row['assistance_id'].'">'. $row['title'] . '</a></td>';
                                    echo '<td>' . $row['submitteddate'] . '</td>';
                                    echo '<td>' . $row['location'] . '</td>';
                                    
                                    echo '<td>';
                                    if ($row['stat'] == 'Verified') {
                                        echo '<p style="color: green">' . $row['stat'] . '</p>';
                                    } elseif ($row['stat'] == 'Pending') {
                                        echo '<p style="color: orange">' . $row['stat'] . '</p>';
                                    } elseif ($row['stat'] == 'Invalid') {
                                        echo '<p style="color: red">' . $row['stat'] . '</p>';
                                    }
                                    echo '</td>';
                                    
                                 echo '<td>';
if ($row['stat'] == 'Verified') {
    echo '<div class="download-button">
            <a href="#" class="downloadButton" data-qrcode-path="../../SocialWorker/qr_codes/' . $row['qr_code_path'] . '">Download QR Card</a>
          </div>';
  echo '<div class="id-card-container">';
echo '<img class="qr-code" src="../../SocialWorker/qr_codes/' . $row['qr_code_path'] . '" alt="QR Code" height="150px">';
echo '</div>';
} else {
    echo 'No QR Code available';
}
echo '</td>';

                                    
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
// Function to trigger the download
function downloadIDCard(qrCodePath) {
    // Create a new canvas and draw the QR code element
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    // Set canvas dimensions
    canvas.width = 500; // Adjust the canvas width as needed
    canvas.height = 800; // Adjust the canvas height as needed

    // Fill the canvas with a white background color
    ctx.fillStyle = '#fff'; // White color
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Load the DORA logo image
    const doraLogo = new Image();
    doraLogo.src = '/Views/SocialWorker/images/dora-logo.png'; // Replace with the actual path to your DORA logo
    doraLogo.onload = function () {
        // Draw the DORA logo at the top
        ctx.drawImage(doraLogo, 50, 20, 100, 50); // Adjust dimensions and position as needed

        // Get the QR code image element
        const qrCode = document.querySelector('.qr-code');

        // Adjust QR code positioning and size
        const qrCodeSize = 200;
        const qrCodeX = (canvas.width - qrCodeSize) / 2; // Center horizontally
        const qrCodeY = 300; // Adjust vertically as needed

        // Draw the QR code image with centered positioning
        ctx.drawImage(qrCode, qrCodeX, qrCodeY, qrCodeSize, qrCodeSize);

        // Draw a dark blue border around the entire canvas
        ctx.strokeStyle = '#001f3f'; // Dark blue color
        ctx.lineWidth = 20; // Border width
        ctx.strokeRect(0, 0, canvas.width, canvas.height);

        // Convert the canvas to a data URL
        const dataURL = canvas.toDataURL('image/png');

        // Create a temporary download link
        const downloadLink = document.createElement('a');

        // Set the download link's href to the data URL and set the download attribute
        downloadLink.href = dataURL;
        downloadLink.download = 'applicant_id_card.png'; // Set the file name

        // Trigger the click event to initiate the download
        downloadLink.click();
    };
}

// Add click event listeners to all download buttons
const downloadButtons = document.querySelectorAll('.downloadButton');
downloadButtons.forEach(button => {
    button.addEventListener('click', function() {
        const qrCodePath = this.getAttribute('data-qrcode-path');
        downloadIDCard(qrCodePath);
    });
});
</script>


    <script>
  let arrow = document.querySelectorAll(".arrow");
  for (var i = 0; i < arrow.length; i++) {
    arrow[i].addEventListener("click", (e)=>{
   let arrowParent = e.target.parentElement.parentElement;
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

