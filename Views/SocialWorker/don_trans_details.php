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

$id = $_GET['id']; 
$transac_id = $_GET['transac_id']; 

$sql = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS name, tbl_dv_accs.image AS image
        FROM tbl_transaction 
        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
        WHERE tbl_transaction.transac_id = $transac_id
        ";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($result)){
    $name = $row['name'];
    $amount = $row['amount'];
    $transaction_id = $row['transaction_id'];
    $submitdate = $row['submitdate'];
    $image_llink = $row['image'];
    $stat = $row['stat'];
}

$title_q = "SELECT * FROM tbl_don_proj RIGHT JOIN tbl_transaction ON tbl_don_proj.don_project_id = tbl_transaction.don_project_id WHERE tbl_transaction.transac_id = $transac_id";
$run = mysqli_query($conn, $title_q);
while ($get = mysqli_fetch_array($run)){
    $title = $get['title'];
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Transaction Details</title>
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\don_trans_details.css">
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
        <h5>Transaction Details</h5>
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
            ?>
          </div>
        </div>
      </li>
    </ul>
  </div>
    
    <section class="home-section">
        <div class="container">
            <div class="back-btn">
                <a href = "donation_transaction.php?id=<?php echo $id ?>"><button class="btn btn-outline-primary m-3" type="button"><i class="bx bx-arrow-back"></i></button></a>
            </div>

            <div class="transaction-receipt">
                <div class="logo-section">
                    <img src="/dora_logo.png" width="100" height="25" class="centered-logo">
                </div>
                <h5 class="receipt-title">Transaction Details</h5>
                <div class="receipt-image">
                    <img src="/uploaded_img/<?php echo $image_llink; ?>" alt="Transaction Image" width="100" height="75">
                    <p> <?php echo $name; ?></p>
                </div>
                <div class="receipt-details">
                    <p class="amount"><strong>&#8369; <?php echo number_format($amount, 2); ?></strong></p>
                    <p class="donation-text">Donation for</p>
                    <p class="donation-text">"<?php echo $title; ?>"</p>
                    <hr>
                    <div class="row">
                        <div class="col-6"><p>Status</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo $stat; ?></strong></p></div>
                    </div>

                    <div class="row">
                        <div class="col-6"><p>Transaction ID</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo $transaction_id; ?></strong></p></div>
                    </div>

                    <div class="row">
                        <div class="col-6"><p>Date</p></div>
                        <div class="col-6 text-end"><p><strong><?php echo date('F j, Y', strtotime($submitdate)); ?></strong></p></div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

    <script>
  function updateMessage() {
    var status = "<?php echo $status; ?>";
    if (status === 'Invalid') {
      var message = "Dear <?php echo $name; ?>, your donation for <strong><?php echo $projectTitle; ?></strong> has been marked as Invalid for the following reasons:\n";
      var checkboxesHTML = '';
      var reasons = document.getElementsByName('reasons[]');
      for (var i = 0; i < reasons.length; i++) {
        if (reasons[i].checked) {
          checkboxesHTML += '<input type="checkbox" checked disabled> ' + reasons[i].value + '<br>';
        }
      }

      message += checkboxesHTML;

      message += "\n\nYou can visit our website for more information.";

      document.getElementById('message').value = message;
    }
  }

  function confirmEmail() {
    Swal.fire({
      title: "Email Sent Successfully",
      text: "The email has been sent successfully.",
      icon: "success",
      confirmButtonText: "OK"
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = 'donation_transaction.php?id=<?php echo $id; ?>';
      }
    });
  }
</script>


<script>
    // Function to trigger SweetAlert for 'Invalid' status
    function markAsInvalid() {
        Swal.fire({
            title: "Transaction Marked as Invalid",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function () {
            window.location.href = "don_trans_details.php?transac_id=<?php echo $transac_id; ?>&id=<?php echo $id; ?>";
        });
    }

    // Function to trigger SweetAlert for 'Verified' status
    function markAsVerified() {
        Swal.fire({
            title: "Transaction Verified Successfully",
            icon: "success",
            confirmButtonText: "OK"
        }).then(function () {
            window.location.href = "don_trans_details.php?transac_id=<?php echo $transac_id; ?>&id=<?php echo $id; ?>";
        });
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
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
