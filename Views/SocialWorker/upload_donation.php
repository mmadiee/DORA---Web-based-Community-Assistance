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
    <title>Upload Donation Project</title>
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
    
    <style>
        .input-field {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
  font-size: 16px;
}

    </style>
   </head>
<body>

<!--LOADER-->
<script src="js/loader.js"></script>
    <div class="loader"></div>
<!-- TITLE BARS -->
  <div class="header">
        <h3>POST DONATION PROJECT</h3>
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
      <!-- UPLOAD CONTENT TO THE DATABASE -->
      <?php 
      //ONCE THE UPLOAD BUTTON IS PRESSED: PROCEED
      if (isset($_POST['upload'])) {
        // Path where the image will go (relative path only)
        $image = $_FILES['image']['name'];    
        // Append a timestamp to the file name to make it unique
        $timestamp = time();
        $image = $timestamp . '_' . $image;
    
        $target = "don_img/" . basename($image);
    
        // Retrieve data submitted from the form
        $text = $_POST['text'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $goal = $_POST['goal'];
        $dropoff = $_POST['dropoff'];
        $paypal_email = $_POST['paypal_email'];
        $end = $_POST['end'];
    
        // INSERT INTO THE DATABASE TABLES
        $sql = "INSERT INTO tbl_don_proj (sw_id, image, text, title, category, goal, dropoff, paypal_email, start, end, proj_stat, ext) VALUES 
        ('$sw_id', '$image', '$text', '$title', '$category', '$goal', '$dropoff', '$paypal_email', DATE(NOW()), '$end', 'PENDING', 0)";
        $query_run = mysqli_query($conn, $sql);
    
        if ($query_run) {
            echo '<script>';
          echo 'Swal.fire({
                  title: "Project Pending for Approval",
                  text: "Your project is now pending for approval.",
                  icon: "info"
              }).then(function() {
                  window.location.href = "current_donation.php";
              });';
          echo '</script>';    
            // Move the uploaded images into the new folder 'don_img'
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
                    window.location.href = "current_donation.php";
                });';
            echo '</script>';
        }
      }
    ?>
    
   <!-- FIELDS OF THE UPLOAD FORM (READ LABELS)-->
   <div class="content">
  <form method="post" action="upload_donation.php" enctype="multipart/form-data">
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
        <option value="Disaster Response">DISASTER RESPONSE</option>
        <option value="Mental Health">ENVIRONMENTAL</option>
        <option value="Physical Health">FOOD SECURITY</option>
        <option value="Mental Health">HEALTH CARE</option>
        <option value="Mental Health">MEDICAL</option>
        <option value="Mental Health">MENTAL HEALTH</option>
        <option value="Food Security">PHYSICAL HEALTH</option>
        <option value="Safe Housing">SAFE HOUSING</option>
        <option value="Mental Health">SPORTS</option>
        <option value="Mental Health">TRANSPORTATION</option>
      </select>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="text">Body</label>
    </div>
    <div class="col-75">
      <textarea id="text" name="text" placeholder="Discuss the Donation Drive Here" style="height:200px" required></textarea>
    </div>
  </div>
  
  <div class="row">
    <div class="col-25">
      <label for="goal">Total Goal</label>
    </div>
    <div class="col-75">
      <input type="number" id="goal" name="goal" placeholder=" &#8369; 0.00" min="1000" max="100000" step="1" required>
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="end">Event Deadline </label>
    </div>
    <div class="col-75">
      <?php
        $currentDate = date('Y-m-d');
        $fortyDaysFromNow = date('Y-m-d', strtotime('+40 days', strtotime($currentDate)));
      ?>
      <input type="date" id="end" name="end" required min="<?php echo date('Y-m-d'); ?>" max="<?php echo $fortyDaysFromNow; ?>">
      <i>**Max project duration is 40 days but you can extend it two (2) times.</i> 
    </div>
  </div>

  <div class="row">
    <div class="col-25">
      <label for="dropoff">Drop Off Location</label>
    </div>
    <div class="col-75">
      <input type="text" id="dropoff" name="dropoff" placeholder="Enter full address for dropoffs" required> 
    </div>
  </div>

  <div class="row">
    <h4 class="subtitle"><br>Paypal Account Information</h4>
  </div>

 <div class="row">
  <div class="col-25">
    <label for="paypal_email">Paypal Email</label>
  </div>
  <div class="col-75">
    <input type="email" id="paypal_email" name="paypal_email" placeholder="Enter your PayPal email account" required class="input-field" value="<?php echo isset($fetch['paypal_account']) ? htmlspecialchars($fetch['paypal_account']) : ''; ?>">
  </div>
</div>


  <!-- UPLOAD TO THE WEBSITE BUTTON --> 
  <br><div class="row">
    <input type="submit" name="upload" value="Upload Project to Website">
  </div>
  </form>
  </div>
  </section>
  

  <!-- FORMAT FOR FIELDS  -->
  <script>
    
    //ACCOUNT NUMBER SET TO 11
    const numberInput = document.getElementById('accnum');
    numberInput.addEventListener('input', function() {
      if (this.value.length > 11) {
        this.value = this.value.slice(0, 11);
      }
    });

    //CONTACT NUMBER SET TO 11
    const numberInput1 = document.getElementById('contact');
    numberInput1.addEventListener('input', function() {
      if (this.value.length > 11) {
        this.value = this.value.slice(0, 11);
      }
    });

    //VALIDATION FOR PAYPAL EMAIL
   document.getElementsByName("paypal_email")[0].addEventListener("input", function () {
  var emailInput = this.value;
  var emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;

  if (!emailRegex.test(emailInput)) {
    alert("Please enter a valid email address.");
  }
});


  
  </script>

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
