<?php
include 'includes/config.php';

session_start();
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (!isset($user_id)) {
    header('location:/login.php');
    exit();
}

if (isset($_GET['logout'])) {
    unset($user_id);
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
    <title>Volunteer Application Form</title>


    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/vol_appform.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">

    <style>
        .valid-image-message {
    display: flex;
    align-items: center;
    padding: 5px;
    border: 1px solid #4CAF50;
    border-radius: 4px;
    color: #4CAF50;
    background-color: #f9f9f9;
    margin-bottom: 10px;
    }

        .valid-image-message i {
            margin-right: 10px;
            color: #4CAF50;
        }
        .submit-btn{
            margin-bottom: 10px;
        }
        #story{
            width:100%;
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
                            <a class="nav-link active" href="volunteer.php">Volunteers</a>
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

    <!-- TITLE BARS -->
    <div class="header">
        <h1>Volunteer Now</h1>
    </div>
      <!-- UPLOAD CONTENT TO THE DATABASE -->
      <?php
      $id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
      if ($id === null) {
          echo "Error: Project ID not provided or invalid.";
          exit();
      }

    $sql_check_applied = "SELECT * FROM tbl_volunteers WHERE vol_proj_id = $id AND user_id = '$user_id'";
    $result_check_applied = mysqli_query($conn, $sql_check_applied);
    if ($result_check_applied && mysqli_num_rows($result_check_applied) > 0) {
        echo '<script>
                Swal.fire({
                    title: "Already Applied",
                    text: "You have already applied for this Volunteer Project.",
                    icon: "info",
                }).then(function() {
                    window.location.href = "volunteer.php";
                });
                </script>';
        exit();
    }
    ?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['volunteer'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : null;

        if (isset($_FILES['image']) && isset($_FILES['image']['error']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];
            $target = "valid_img/" . basename($file_name);

            if (move_uploaded_file($file_tmp, $target)) {
                $msg = "Image uploaded successfully";
                $valid = "'" . $file_name . "'";
            } else {
                $msg = "Error uploading image";
            }
        } else {
            $msg = "No image uploaded";
            $valid = "NULL";
            $target = null; 
        }

        $story = isset($_POST['story']) ? mysqli_real_escape_string($conn, $_POST['story']) : '';
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
        $id = isset($_POST['id']) ? $_POST['id'] : '';

        $sql = "INSERT INTO tbl_volunteers (vol_proj_id, user_id, story, valid, stat, submitteddate) 
                VALUES ('$id', '$user_id', '$story', $valid, 'Pending', NOW())";

        if ($valid === "NULL") {
            $sql = "INSERT INTO tbl_volunteers (vol_proj_id, user_id, story, stat, submitteddate) 
                    VALUES ('$id', '$user_id', '$story', 'Pending', NOW())";
        }

        $query_run = mysqli_query($conn, $sql);

        if ($query_run) {
            echo '<script>';
            echo 'Swal.fire({
                    title: "Application Submitted!",
                    text: "Please Wait for verification.",
                    icon: "success",
                  }).then(function() {
                      window.location.href = "volunteer.php";
                  });';
            echo '</script>';
            exit();
        } else {
            echo '<script>';
            echo 'Swal.fire({
                    title: "Error",
                    text: "There was a problem submitting your application.",
                    icon: "error",
                  }).then(function() {
                      window.location.href = "vol_appform.php?id=' . $id . '"; // Redirect to the application form page
                  });';
            echo '</script>';
        }
    }
    ?>


<?php
    $validImageExists = false;  
    $sql_check_valid_image = "SELECT valid_image FROM tbl_dv_accs WHERE user_id = ?";
    $stmt_check_valid_image = mysqli_prepare($conn, $sql_check_valid_image);

    if ($stmt_check_valid_image) {
        mysqli_stmt_bind_param($stmt_check_valid_image, "s", $user_id);
        mysqli_stmt_execute($stmt_check_valid_image);

        $result_check_valid_image = mysqli_stmt_get_result($stmt_check_valid_image);

        if ($result_check_valid_image && mysqli_num_rows($result_check_valid_image) > 0) {
            $row_valid_image = mysqli_fetch_assoc($result_check_valid_image);
            if (!empty($row_valid_image['valid_image'])) {
                $validImageExists = true;
            }
        }
        mysqli_stmt_close($stmt_check_valid_image);
    }
    ?>


<!-- Content-->
<?php
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbl_vol_proj WHERE vol_proj_id = '$id'";
    $result = mysqli_query($conn, $sql);

    echo '<div class="back-btn">
    <a href="vol_projects.php?id=' . $id . '"><button type="button" class="btn">Back to Project Details</button></a>
    </div>';

         // QUERY TO KNOW THE NUMBER OF VOLUNTEERS
         $sql2 = "SELECT user_id, vol_proj_id FROM tbl_volunteers WHERE vol_proj_id = $id AND stat = 'Verified' GROUP BY user_id";
         $mysqliStatus = $conn->query($sql2);
        $vol_count = mysqli_num_rows($mysqliStatus);
                                
        while ($row = mysqli_fetch_array($result)){
            //PROGRESS BAR
            $percentage = ($vol_count / $row['totalGoal']) * 100;
            $remaining = $row['totalGoal'] - $vol_count;
            
            //RETRIVING OF INFO FROM THE DATABASE
            echo ' 
          <div class="container w-75 title">
            <div class="title-box">
              <div class="row">
                <p class="donate-to">Register to</p">
                <div class="col-8">
                    <h3>'.$row['title'].' </h3>
                </div>
                <div class="col-4">
                    <div class = "box">
                        <p class = "progress-raised"> '.$vol_count.' registered volunteers</p>   
                        <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar" style="width: '.$percentage.'%"></div>
                        </div>'; if ($vol_count >= $row['totalGoal']){
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

<div class="container w-75  ">
        <div class="formcontainer">
            <form method="post" action="vol_appform.php?id=<?php echo $id ?>" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $id;?>">

                <div class="row">
                    <div class="col-25">
                        <b><p class="geninf">Fill up needed information</p></b>
                    </div>
                </div>

                <input type="hidden" value="<?php echo $user_id?>" name="user_id">

                <div class="row">
                    <div class="col-25">
                        <label for="story">Purpose</label>
                    </div>
                    <div class="col-75">
                        <input type="text" id="story" name="story" placeholder="Indicate why you want to participate in this volunteer program.." required>
                    </div>
                </div>

                <div class="row">
                <div class="col-25">
                    <label for="image">Upload Valid ID for Verification</label>
                </div>
                <div class="col-75">
                    <?php
                    if ($validImageExists) {
                        echo '<div class="valid-image-message">
                                <i class="fas fa-check-circle"></i> You have already uploaded a valid image
                            </div>';
                    } else {
                        echo '<input type="file" name="image" id="image" required>';
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="submit-btn">
                    <input type="submit" name="volunteer" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>

    <?php
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
    
        $target = "valid_img/" . basename($file_name);
    
        if (move_uploaded_file($file_tmp, $target)) {
            $msg = "Image uploaded successfully";
        } else {
            $msg = "Error uploading image";
        }
    } else {
        $target = NULL;
        $msg = "No image uploaded";
    }
    
    ?>

    <!--FOOTER-->
    <footer class="sticky-footer">
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="donation.php">Donations</a></li>
            <li><a href="volunteer.php">Volunteers</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>

