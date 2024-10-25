<?php
include 'includes/config.php';

session_start();
$appli_id = $_SESSION['appli_id'];

if (!isset($appli_id)) {
    header('location:/login.php');
    exit();
}

if (isset($_GET['logout'])) {
    unset($appli_id);
    session_destroy();
    header('location:/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistance Application Form</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
     crossorigin="anonymous" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/dn-now.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
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
                            <a class="nav-link active" href="assistance.php">Assistance</a>
                        </li>             
                        <li class="nav-item">
                            <a class="nav-link" href="a_userdashboard.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                    '?>
            </div>
        </div>
    </nav>

    <!-- TITLE BARS -->
    <div class="header">
        <h1>Apply Now</h1>
    </div>
      <!-- UPLOAD CONTENT TO THE DATABASE -->

      <?php
      // Check if the user has already applied for this project
        $id = $_GET['id'];
        $sql_check_applied = "SELECT * FROM tbl_applicants WHERE assistance_id = $id AND appli_id = '$appli_id'";
        $result_check_applied = mysqli_query($conn, $sql_check_applied);
        if (mysqli_num_rows($result_check_applied) > 0) {
            // User has already applied for this project
            echo '<script>
                Swal.fire({
                    title: "Already Applied",
                    text: "You have already applied for this Assistance Project.",
                    icon: "info",
                }).then(function() {
                    window.location.href = "assistance.php";
                });
                </script>';
            exit();}
            
            ?>
    
      <?php 
      //ONCE THE UPLOAD BUTTON IS PRESSED: PROCEED
      if(isset($_POST['assistance'])){
    
        //PATH OF WHERE THE IMAGE WILL GO
        $target = "assistance_img/".basename($_FILES['image']['name']);

        //RETRIVE DATA SUBMITTED FROM THE FORM
        $text = $_POST['text'];
        $image = $_FILES['image']['name'];
        $appli_id = $_POST['appli_id'];
        $id = $_POST['id'];

       //INSERT INTO THE DATABASE TABLES
        $sql3 = "INSERT INTO tbl_applicants (assistance_id, appli_id, text, proof, stat, submitteddate) VALUES 
        ('$id', '$appli_id', '$text', '$image', 'Pending', DATE(NOW()))";
        $query_run = mysqli_query($conn, $sql3); //THIS CODE STORES THE RECORDS INTO THE DATABASE

        if ($query_run) {
            echo '<script>';
            echo 'Swal.fire({
                    title: "Application Submitted!",
                    text: "Wait for your verification.",
                    icon: "success",
                  }).then(function() {
                      window.location.href = "assistance.php";
                  });';
            echo '</script>';
            // MOVE THE UPLOADED IMAGES INTO THE NEW FOLDER 'don_img'
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
              $msg = "Image uploaded successfully";
            } else {
              $msg = "Error uploading image";
            }
          } else {
            echo '<script>';
            echo 'Swal.fire({
                    title: "Error",
                    text: "There was a problem submitting your transaction.",
                    icon: "error",
                  }).then(function() {
                      window.location.href = "assistance.php";
                  });';
            echo '</script>';
          }
        }
    ?>

    <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_assistance where assistance_id  = '$id'";
        $result = mysqli_query($conn, $sql);

        echo '
        <div class="back-btn">
          <a href="assistance_projects.php?id='.$id.'"><button type="button" class="btn">Back to Assistance Project Details</button></a>
        </div>
        ';

         // QUERY TO KNOW THE NUMBER OF ASSISTANCE APPLICANTS
         $sql2 = "SELECT appli_id, assistance_id FROM tbl_applicants WHERE assistance_id = $id AND stat = 'Verified' GROUP BY appli_id";
                $mysqliStatus = $conn->query($sql2);
                $assist_count = mysqli_num_rows($mysqliStatus);
                                
        while ($row = mysqli_fetch_array($result)){
            //PROGRESS BAR
            $percentage = ($assist_count / $row['avail_slot']) * 100;

            $remaining = $row['avail_slot'] - $assist_count;
            $req = $row['requirement'];
            //RETRIVING OF INFO FROM THE DATABASE
            echo ' 
            <div class="container w-75 title">
                <div class="title-box">
                <div class="row">
                    
                    <div class="col-8">
                        <p class="donate-to">Apply For Assistance to</p">
                        <h3>'.$row['title'].' </h3>
                    </div>
                    <div class="col-4">
                        <div class = "box">
                            <p class = "progress-raised"> '.$assist_count.' registered volunteers</p>   
                            <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar" style="width: '.$percentage.'%"></div>
                            </div> '; if ($assist_count >= $row['avail_slot']){
                                echo '<p class="progress-to-go">Goal Reached!</p>';
                            }else{ echo '                               
                            <p class = "progress-to-go"> '.$remaining.' to go </p> ';} echo '
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
        }
    ?>
    <div class="container w-75">
        <div class="formcontainer ">
            <form method="post" action="assist_appform.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-25">
                        <b><p class="geninf">Fill up needed information</p></b>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $id; ?>" name="id">
                <input type="hidden" value="<?php echo $appli_id?>" name="appli_id">

                <div class="row">
                    <div class="col-25">
                        <label for="text">Purpose</label>
                    </div>
                    <div class="col-75">
                        <textarea id="text" name="text" placeholder="Indicate why you need this assistance.." required></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-25">
                        <input type="hidden" name="size" value="1000000">
                        <label for="image">Upload <b> <?php echo $req; ?> </b> </label>
                    </div><br>
                    <div class="col-75">
                        <input type="file" name="image" required>
                    </div>
                </div>
                    
                <div class="row">
                    <div class="submit-btn">
                        <input type="submit" name="assistance" value="Submit">
                    </div>
                </div>  
            </form>
        </div>
    </div>
        

    <!--FOOTER-->
    <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="social_assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        
</body>
</html>

