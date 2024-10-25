<?php
include 'includes/config.php';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:/login.php');
    exit; // Terminate script execution after redirection
}

if (isset($_GET['logout'])) {
    unset($user_id);
    session_destroy();
    header('location:/index.php');
    exit; // Terminate script execution after redirection
}

require 'phpqrcode/qrlib.php';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title>Donor/Volunteer</title>
    <link rel="stylesheet" href="css/donation.css">
    <link rel="stylesheet" href="css/donation_transaction.css">
    <link rel="stylesheet" href="css/id.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ"
        crossorigin="anonymous">

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
    .download-button {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px; /* Add margin at the bottom */
    }

    .download-button a {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff; /* Blue background color */
        color: #fff; /* White text color */
        text-decoration: none;
        border-radius: 5px;
    }

    .download-button a:hover {
        background-color: #0056b3; /* Darker blue color on hover */
    }
    </style>
</head>

<body>

    <!-- LOADER -->
    <script src="js/loader.js"></script>
    <div class="loader"></div>

    <!-- NAV BAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a href="index.php" class="navbar-brand"><img src="dora_logo.png" width="120" height="30"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                echo '
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
                '
                ?>
            </div>
        </div>
    </nav>

    <?php
    $id = $_GET['id'];
    $volunteer_id = $_GET['volunteer_id'];
    $sql = "SELECT * FROM tbl_vol_proj right join tbl_sw_accs on tbl_vol_proj.sw_id = tbl_sw_accs.sw_id  where tbl_vol_proj.vol_proj_id = '$id' ";
    $result = mysqli_query($conn, $sql);

    echo '
            <div class="back-btn">
            <a href="vol-verification.php?volunteer_id=' . $volunteer_id . '&id=' . $id . '"><button class="b-btn" type="button">Back to Volunteer Information</button></a>
            </div>';
    ?>

    <?php
    $sql5 = "SELECT *, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS full_name
    FROM tbl_volunteers RIGHT JOIN tbl_dv_accs ON tbl_volunteers.user_id = tbl_dv_accs.user_id 
    WHERE tbl_volunteers.volunteer_id = '$volunteer_id'";
    $result = mysqli_query($conn, $sql5);

    if (!$result) {
        die("Database query failed.");
    }

    $row = mysqli_fetch_array($result);

    if (!$row) {
        die("No data found for this volunteer.");
    }

    $vol_proj_id = $_GET['id'];
    $sqlVolunteer = "SELECT title FROM tbl_vol_proj WHERE vol_proj_id = '$vol_proj_id'";
    $resultVolunteer = mysqli_query($conn, $sqlVolunteer);
    $rowVolunteer = mysqli_fetch_array($resultVolunteer);
    $projectTitle = $rowVolunteer['title'];
    ?>

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

        // Set the path to save QR code images
        $qrFileName = "/Views/SocialWorker/vol_qrcodes/volunteer_$volunteer_id.png";

        // Generate QR code
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

    <div class="download-button">
        <a href="#" id="downloadButton">Download ID Card</a>
    </div><br>
    </div>

    <script>
        // Function to trigger the download
        function downloadIDCard() {
            // Create a new canvas to combine ID image, QR code, text, DORA logo, border, and background
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Set canvas dimensions
            canvas.width = 500; // Adjust the canvas width as needed
            canvas.height = 800; // Adjust the canvas height as needed

            // Fill the canvas with a white background color
            ctx.fillStyle = '#fff'; // White color
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Get the ID image, QR code image, and DORA logo elements
            const idImage = document.querySelector('.id-image img');
            const qrCode = document.querySelector('.qr-code img');
            const doraLogo = document.querySelector('.logo img');

            // Get the dimensions of the QR code
            const qrCodeWidth = qrCode.width;
            const qrCodeHeight = qrCode.height;

            // Set dimensions for the elements (using QR code dimensions)
            const imageWidth = qrCodeWidth; // Set the image width to match QR code width
            const imageHeight = qrCodeHeight; // Set the image height to match QR code height
            const logoWidth = 100; // Set the logo width (reduced)
            const logoHeight = 50; // Set the logo height (reduced)

            // Calculate margins for the image and QR code to center them horizontally
            const horizontalMargin = (canvas.width - imageWidth) / 2;

            // Draw the DORA logo at the top center
            const logoX = (canvas.width - logoWidth) / 2;
            const logoY = 20; // Adjust the margin from the top as needed
            ctx.drawImage(doraLogo, logoX, logoY, logoWidth, logoHeight);

            // Draw the ID image on the canvas
            ctx.drawImage(idImage, horizontalMargin, 120, imageWidth, imageHeight); // Adjust dimensions and position as needed

            // Draw the QR code image
            ctx.drawImage(qrCode, horizontalMargin, 120 + imageHeight + 20, qrCodeWidth, qrCodeHeight); // Use QR code dimensions

            // Draw a blue border around the entire canvas
            ctx.strokeStyle = '#034078'; // Blue color
            ctx.lineWidth = 20; // Border width
            ctx.strokeRect(0, 0, canvas.width, canvas.height);

            // Define text properties
            ctx.font = 'bold 20px Consolas'; // Bold and 20px font size
            ctx.fillStyle = '#007bff'; // Text color

            // Define the text content using JavaScript variables
            const fullName = '<?php echo $row['full_name']; ?>';
            const occupation = '<?php echo $row['occupation']; ?>';
            const volunteerNumber = '<?php echo 'Volunteer ID: '. $row['volunteer_id']; ?>';
            const cardIssuedDate = '<?php echo 'Card Issued: ' . date("F j, Y", strtotime($row['submitteddate'])); ?>';

            // Position and draw the text on the canvas
            ctx.textAlign = 'center'; // Center-align text

            // Position the text at the bottom of the QR code
            const textY = 120 + imageHeight + qrCodeHeight + 40; // Adjust the vertical position as needed

            // Draw each text element at the specified position with appropriate vertical spacing
            ctx.fillText(fullName, canvas.width / 2, textY);
            ctx.fillText(occupation, canvas.width / 2, textY + 30); // Adjust vertical spacing
            ctx.fillText(volunteerNumber, canvas.width / 2, textY + 60); // Adjust vertical spacing
            ctx.fillText(cardIssuedDate, canvas.width / 2, textY + 90); // Adjust vertical spacing

            // Convert the canvas to a data URL
            const dataURL = canvas.toDataURL('image/png');

            // Create a temporary download link
            const downloadLink = document.createElement('a');

            // Set the download link's href to the data URL and set the download attribute
            downloadLink.href = dataURL;
            downloadLink.download = 'volunteer_id_card_<?php echo $row['volunteer_id']; ?>.png'; // Set the file name

            // Trigger the click event to initiate the download
            downloadLink.click();
        }

        // Add a click event listener to the download button
        const downloadButton = document.getElementById('downloadButton');
        downloadButton.addEventListener('click', downloadIDCard);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
