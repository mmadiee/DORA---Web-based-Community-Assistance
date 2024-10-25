<?php
include 'includes/config.php';

session_start();
$sw_id = $_SESSION['sw_id'];

if (!isset($sw_id)) {
    header('location:/login.php');
}

if (isset($_GET['logout'])) {
    unset($sw_id);
    session_destroy();
    header('location:/index.php');
}

require 'phpqrcode/qrlib.php';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Social Worker</title>
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/don_trans_details.css">
    <link rel="stylesheet" href="css/id.css">


    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" rel="stylesheet">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
</head>

<style>
    .download-button {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px; 
    }

    .download-button a, button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff; 
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: 0px;
    }

    .download-button a:hover, button:hover {
        background-color: #0056b3; 
    }

    .form-container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
    background-color: #f0f0f0;
    border-radius: 10px;
    border: 10px solid #001F54;
     margin-bottom: 100px;
}


    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    label {
        font-weight: bold;
    }

    .submit-button {
        margin-top: 10px; 
        margin-bottom: 10px; 
    }
    
</style>

<body>

<!-- LOADER -->
<script src="js/loader.js"></script>
<div class="loader"></div>

<!-- TITLE BARS -->
<div class="header">
    <h5>VOLUNTEER INFORMATION</h5>
</div>

<div class="sidebar close">
    <div class="logo-details">
        <i img src="images/dora.png" alt="doralogo"></i>
        <span class="logo_name">DORA</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="socialworker_home.php">
                <i class='bx bx-home'></i>
                <span class="link_name">Home</span>
            </a>
        </li>
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
                <a href="/login.php"
                   onclick="document.querySelector('button[name=\'end\']').click();">
                    <i class='bx bx-log-out'></i>
                    <input type="hidden" name="end" value="true">
                    <span class="link_name">Logout</span>
                </a>
                <button type="submit" name="end"
                        style="display: none;"></button>
            </form>
        </li>

        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <?php
                    $select = mysqli_query($conn, "SELECT * FROM `tbl_sw_accs` WHERE sw_id = '$sw_id'") or die('query failed');
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
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
    </div>

    <?php
    $id = $_GET['id'];
    $volunteer_id = $_GET['volunteer_id'];
    $sql = "SELECT * FROM tbl_vol_proj right join tbl_sw_accs on tbl_vol_proj.sw_id = tbl_sw_accs.sw_id  where tbl_vol_proj.vol_proj_id = '$id' ";
    $result = mysqli_query($conn, $sql);

    echo '
            <div class="back-btn">
            <a href="vol-verification.php?volunteer_id=' . $volunteer_id . '&id=' . $id . '"><button class="btn btn-outline-primary ms-5" type="button">Back to Volunteer Information</button></a>
            </div>';
    ?>

    <?php
    $sql5 = "SELECT *, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS full_name
    FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id 
    WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";
    $result = mysqli_query($conn, $sql5);
    $row = mysqli_fetch_array($result); 
    $vol_proj_id = $_GET['id'];
    $sqlVolunteer = "SELECT title FROM tbl_vol_proj WHERE vol_proj_id = '$vol_proj_id'";
    $resultVolunteer = mysqli_query($conn, $sqlVolunteer);
    $rowVolunteer = mysqli_fetch_array($resultVolunteer);
    $projectTitle = $rowVolunteer['title'];
    ?>
    
    <div class="container-centering">
    <div class="container-idz id-card">
        <div class="logo">
            <img src="/Views/SocialWorker/images/dora-logo.png" alt="DORA Logo" class="logo">
        </div>
        <div class="id-image">
            <img src="/uploaded_img/<?php echo $row['image']; ?>" alt="Electronic ID Image">
        </div>
        <h3 class="id-title"><?php echo $row['full_name']; ?></h3>
        <div class="id-details">
            <p><?php echo $row['occupation']; ?></p>
        </div>

        <?php
        $qrContent = "Volunteer ID: $volunteer_id\nName: {$row['full_name']}\nContact: {$row['full_contact']}\nEmail: {$row['email']}\nStatus: {$row['stat']}\nProject Title: $projectTitle";

        $qrFileName = "../../Views/SocialWorker/vol_qrcodes/volunteer_$volunteer_id.png";

        QRcode::png($qrContent, $qrFileName, QR_ECLEVEL_L, 5);

        $qrImagePath = $qrFileName;
        $updateQrImageQuery = "UPDATE tbl_volunteers SET image_path = '$qrImagePath' WHERE volunteer_id = '$volunteer_id'";
                mysqli_query($conn, $updateQrImageQuery);

        $fullName = $row['full_name'];
        $occupation = $row['occupation'];
        $volunteerNumber = $row['volunteer_id'];
        $cardIssuedDate = date("F j, Y", strtotime($row['submitteddate']));
        ?>

        <div class="qr-code" style="margin-top: 20px;">
            <img src="<?php echo $qrFileName; ?>" alt="QR Code" style="max-width: 250px;">
        </div>
        <p>Volunteer Number: <?php echo $volunteerNumber; ?> </p>
        <p>Card Issued: <?php echo $cardIssuedDate; ?></p>
    </div>
    </div>

   <div class="download-button">
    <a href="#" id="downloaconnutton">Download ID Card</a>
        <button type="button" class="button" style="margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#emailModal">Send Email</button>
    </div><br>
</div>

    <!-- email modal -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelleconny="emailModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="emailModalLabel">Send Email</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- Email form content -->
            <form action="send_email_vol.php" method="post">
              
              <div class="mb-3">
                <label for="recipientEmail" class="form-label"><b>Recipient Email</b></label>
                <input type="email" class="form-control" id="email" name="email" value="' . $email . '" required>
              </div>

      <div class="">
                <label for="subject" class="form-label"><b>Subject</b></label>
                <input type="text" class="form-control" name="subject" id="subject" value="' . $subject . '" required>
                            </div>

      <div class="mb-3">
                <label for="message" class="form-label"><b>Message</b></label>
                <textarea class="form-control" name="message" id="message" rows="6" required>' . $message . '</textarea>
                            </div>

    <!-- Hidden input field for project title -->
              <input type="hidden" name="project_title" value="' . $projectTitle . '">


              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="javascript:void(0);" onclick="confirmEmail()">
                  <button type="submit" name="send" class="btn btn-primary">Send Email</button>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    
    <script>
    function downloadIDCard() {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    canvas.width = 500; 
    canvas.height = 800; 
    ctx.fillStyle = '#fff'; 
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    const idImage = document.querySelector('.id-image img');
    const qrCode = document.querySelector('.qr-code img');
    const doraLogo = document.querySelector('.logo img');

    const qrCodeWidth = qrCode.width;
    const qrCodeHeight = qrCode.height;

    const imageWidth = qrCodeWidth; 
    const imageHeight = qrCodeHeight; 
    const logoWidth = 100; 
    const logoHeight = 50; 

    const horizontalMargin = (canvas.width - imageWidth) / 2;
    const logoX = (canvas.width - logoWidth) / 2;
    const logoY = 20; 
    ctx.drawImage(doraLogo, logoX, logoY, logoWidth, logoHeight);

    ctx.drawImage(idImage, horizontalMargin, 120, imageWidth, imageHeight); 
    ctx.drawImage(qrCode, horizontalMargin, 120 + imageHeight + 20, qrCodeWidth, qrCodeHeight); 

    ctx.strokeStyle = '#034078'; 
    ctx.lineWidth = 20; 
    ctx.strokeRect(0, 0, canvas.width, canvas.height);

    ctx.font = 'bold 20px Consolas'; 
    ctx.fillStyle = '#007bff'; 

    const fullName = '<?php echo $row['full_name']; ?>';
    const occupation = '<?php echo $row['occupation']; ?>';
    const volunteerNumber = '<?php echo 'Volunteer ID: '. $row['volunteer_id']; ?>';
    const cardIssuedDate = '<?php echo 'Card Issued: ' . date("F j, Y", strtotime($row['submitteddate'])); ?>';

    ctx.textAlign = 'center'; 

    const textY = 120 + imageHeight + qrCodeHeight + 40; 

    ctx.fillText(fullName, canvas.width / 2, textY);
    ctx.fillText(occupation, canvas.width / 2, textY + 30); 
    ctx.fillText(volunteerNumber, canvas.width / 2, textY + 60); 
    ctx.fillText(cardIssuedDate, canvas.width / 2, textY + 90); 

    const dataURL = canvas.toDataURL('image/png');
    const downloadLink = document.createElement('a');
    downloadLink.href = dataURL;
    downloadLink.download = 'volunteer_id_card_<?php echo $row['volunteer_id']; ?>.png'; // Set the file name
    downloadLink.click();
}
    const downloaconnutton = document.getElementById('downloaconnutton');
    downloaconnutton.addEventListener('click', downloadIDCard);       

    </script>

<script>
    var volunteerEmail = '<?php echo $row['email']; ?>';
    function populateEmail() {
        var emailInput = document.getElementById('email');
        emailInput.value = volunteerEmail;
    }
    window.onload = populateEmail;
</script>

<script>
    var predefinedSubject = '';
    var predefinedMessage = '';

    var volunteerStatus = '<?php echo $row['stat']; ?>';

    var projectTitle = '<?php echo $projectTitle; ?>';

    if (volunteerStatus === 'Verified') {
        predefinedSubject = 'Verified Application';
        predefinedMessage = 'Good Day! You are now a Verified participant for the project: "' + projectTitle + '". The Electronic ID is now available at your designated DORA Account. See you soon!';
    } else {
        predefinedSubject = 'Default Subject';
        predefinedMessage = 'Default Message';
    }
    function populateSubjectAndMessage() {
        var subjectInput = document.getElementById('subject');
        var messageInput = document.getElementById('message');

        subjectInput.value = predefinedSubject;
        messageInput.value = predefinedMessage;
    }

    window.onload = function () {
        populateEmail(); 
        populateSubjectAndMessage(); 
    };
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
        window.location.href = 'view-volunteers.php?id=<?php echo $id; ?>';
      }
    });
  }
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
</body>
</html>
