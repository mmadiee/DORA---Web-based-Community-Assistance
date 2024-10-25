<?php
include 'includes/config.php';

session_start();
$sw_id = $_SESSION['sw_id'];

if(!isset($sw_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($sw_id);
   session_destroy();
   header('location:/index.php');
}
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Upload Volunteer Project</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="css/upload.css">
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

   <!--ICONS-->
   <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
  
    </head>
<body>

  <!--LOADER-->
  <script src="js/loader.js"></script>
      <div class="loader"></div>

  <!-- TITLE BARS -->
  <div class="header">
        <h3>POST VOLUNTEER PROJECT</h3>
  </div>

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
          <a href="/login.php">
            <i class='bx bx-log-out'></i>
            <span class="link_name">Logout</span>
          </a>
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
          ?>
        </div>
  </div>
  </li>
  </ul>
  </div>
  
  <!-- SECTION FOR CONTENT -->
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
      <span class="text">Enter Project Details</span>
    </div>
      <?php
        if (isset($_POST['upload'])) {
          
          $image = $_FILES['image']['name'];
          
          // Append a timestamp to the file name to make it unique
          $timestamp = time();
          $image = $timestamp . '_' . $image;
      
          // PATH OF WHERE THE IMAGE WILL GO (RELATIVE PATH ONLY)
          $target = "vol_img/" . basename($image);
          
          // RETRIEVE DATA SUBMITTED FROM THE FORM
          $title = $_POST['title'];
          $category = $_POST['category'];
          $eventDate = $_POST['eventDate'];
          $text = $_POST['text'];
          $requirement = $_POST['requirement'];
          $totalGoal = $_POST['totalGoal'];
          $location = $_POST['location'];
          $uploadDate = date("Y-m-d");
          $proj_stat = 'PENDING';
          
          // INSERT INTO THE DATABASE TABLES
          $sql = "INSERT INTO tbl_vol_proj (sw_id, title, image, category, uploadDate, eventDate, text, requirement, totalGoal, location, proj_stat) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
          
          // Create a prepared statement
          $stmt = mysqli_prepare($conn, $sql);
          
          if ($stmt) {
              // Bind parameters to the statement
              mysqli_stmt_bind_param($stmt, "issssssssss", $sw_id, $title, $image, $category, $uploadDate, $eventDate, $text, $requirement, $totalGoal, $location, $proj_stat);
          
              // Execute the statement
              $query_run = mysqli_stmt_execute($stmt);
          
              if ($query_run) {
                echo '<script>';
                echo 'Swal.fire({
                        title: "Project Pending for Approval",
                        text: "Your project is now pending for approval.",
                        icon: "info"
                    }).then(function() {
                        window.location.href = "current_volunteer.php";
                    });';
                echo '</script>';                
                  
                  // MOVE THE UPLOADED IMAGES INTO THE NEW FOLDER 'vol_img'
                  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                      $imageMsg = "Image uploaded successfully";
                  } else {
                      $imageMsg = "Error uploading image";
                  }
              } else {
                  echo '<script>';
                  echo 'Swal.fire({
                          title: "Error",
                          text: "There was a problem uploading your project.",
                          icon: "error",
                        }).then(function() {
                            window.location.href = "current_volunteer.php";
                        });';
                  echo '</script>';
              }
          
              // Close the statement
              mysqli_stmt_close($stmt);
          }
        }
      ?>

    
   <!-- FIELDS OF THE UPLOAD FORM (READ LABELS)-->
   <div class="content">
  <form method="post" action="upload_volunteer.php" enctype="multipart/form-data">
  <div class="row">
    <div class="col-25">
      <label for="title">Title of the Project</label>
    </div>
    <div class="col-75">
      <input type="text" id="title" name="title" placeholder="What is your project all about?" required>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <input type="hidden" name="size" value="1000000">
      <label for="image">Enter Project Image</label>
    </div><br>
    <div class="col-75">
      <input type="file" name="image" required accept=".jpg, .jpeg, .png">
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="category">Category</label>
    </div>
    <div class="col-75">
      <select id="category" name="category">
          <option value="Physical Health">ANIMAL RESCUE</option>
        <option value="Disaster Response">DISASTER RESPONSE</option>
        <option value="Physical Health">COMMUNITY SERVICE</option>
        <option value="Physical Health">EDUCATION AND TUTORING</option>
        <option value="Physical Health">ENVIRONMENTAL</option>
        <option value="Physical Health">FOOD SECURITY</option>
        <option value="Mental Health">MENTAL HEALTH</option>
        <option value="Food Security">PHYSICAL HEALTH</option>
        <option value="Safe House">SAFE HOUSING</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="text">Body</label>
    </div>
    <div class="col-75">
      <textarea id="text" name="text" placeholder="Discuss the volunteer project details here." style="height:200px" required></textarea>
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="requirement">Preferred Volunteer:</label>
    </div>
    <div class="col-75">
      <input type="text" id="requirement" name="requirement" placeholder="Indicate here what you're looking for in a volunteer" required>
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="totalGoal">Needed number of Volunteers</label>
    </div>
    <div class="col-75">
      <input type="number" id="totalGoal" name="totalGoal" placeholder="10" min="0" max="100" step="1" required>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="location">Project Location</label>
    </div>
    <div class="col-75">
      <input type="text" id="location" name="location" placeholder="Enter full address of project location" required>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="upload_date">Date of Project</label>
    </div><br>
    <div class="col-75">
      <input type="date" id="eventDate" name="eventDate" required min="<?php echo date('Y-m-d'); ?>">
    </div>
  </div>

      <!-- UPLOAD TO THE WEBSITE BUTTON -->
          <br><div class="row">
              <input type="submit" name="upload" value="Upload Project to Website">
              </div>
      </form>
    </div>
  </section>

  
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
