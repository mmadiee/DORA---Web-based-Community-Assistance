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

<?php 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id']; 

// SQL query to retrieve transaction details
$sql = "SELECT tbl_transaction.transac_id, tbl_transaction.transaction_id, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name, tbl_transaction.amount, tbl_transaction.submitdate AS date
        FROM tbl_transaction
        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id
        WHERE tbl_transaction.don_project_id = $id AND stat = 'Verified'";


$result = $conn->query($sql);

// Donation Details, Amount, and Donor Count
$sql1 = "SELECT dp.title AS title, dp.goal AS goal, dp.start AS start, dp.proj_stat AS proj_stat, dp.end AS end, CONCAT(sw.fname, ' ', sw.lname) AS sw_name, sw.email AS email, SUM(t.amount) AS total_donation, COUNT(t.transac_id) AS donor_count
        FROM tbl_don_proj dp
        RIGHT JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
        LEFT JOIN tbl_transaction t ON dp.don_project_id = t.don_project_id
        WHERE dp.don_project_id = $id AND t.stat = 'verified'";

$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$donation = $row1['total_donation'];

if ($donation !== null && is_numeric($donation)) {
    // Assuming $donation is a numeric value
    $donation = number_format($donation);
    
} else {
    $donation = 0;
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <title>Donation Transactions</title>
    
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css\sidebar.css">
    <link rel="stylesheet" href="css\donation_transaction.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


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
        <h5>Donation Transactions</h5>
    </div>

  <div class="sidebar close">
    <div class="logo-details">
    <i  img src="images/dora.png" alt="doralogo"></i>
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
                <a href = "donation-details.php?id=<?php echo $id ?>"><button class="btn btn-outline-primary m-3" type="button"><i class="bx bx-arrow-back"></i></button></a>
            </div>
            <?php
                if ($result && $result1->num_rows > 0) {
                    echo '<div class="container text-center w-75">';
                    echo '<div class="row">
                            <a href="/donation_projects.php?id=' . $id . '" target="blank"><h3>' . $row1['title'] . '</h3></a>
                            ';
                            
                    echo '</div>';

                    echo '<div class="row">
                            <div class="data-box">
                                <div class="row">
                                    <div class="col-3">
                                        <p class="data"> &#8369;' . number_format($row1['goal']) . '</p>
                                        <p class="data-label">Total Goal</p>
                                    </div>
                                    <div class="col-3">
                                        <p class="data"> &#8369;' . number_format($donation) . '</p>
                                        <p class="data-label">Donations</p>
                                    </div>
                                    <div class="col-3">';
                                    if ($row1['total_donation'] >= $row1['goal']) {
                                        echo '<p class="data"><span>&#10003;</span></p>
                                            <p class="data-label">Goal Reached!</p>';
                                    } else {
                                        $remaining = $row1['goal'] - $row1['total_donation'];
                                        echo '<p class="data"> &#8369;' . number_format($remaining) . '</p>
                                            <p class="data-label">Remaining</p>';
                                    }
                                    echo' 
                                </div>
                                <div class="col-3">
                                    <p class="data">' . $row1['donor_count'] . '</p>
                                    <p class="data-label">Donors Count</p>
                                </div>
                            </div>
                        </div>
                    </div>';
                    
                }
            ?>
        </div>
        
        
        <div class="container">
                <!--Export Donation List Button-->
                <div style="display: flex; justify-content: center;">
                    <a href="report_don_list.php?id=<?php echo $id; ?>" target="_blank">
                        <button class="btn btn-outline-primary mt-3 mb-3">Export List</button>
                    </a>
                </div>

                <div class="con-table pb-3">
                    <ul class="nav nav-underline" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-tab-pane" type="button" role="tab" aria-controls="all-tab-pane" aria-selected="true">All</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-tab-pane" type="button" role="tab" aria-controls="verified-tab-pane" aria-selected="false">Verified</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane" aria-selected="false">Pending</button>
                      </li>
                    </ul>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                       
                                        <th scope="col" style="width: 20%; text-align: left;">Name</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Amount</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Date</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Transaction ID</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Status</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                                FROM tbl_transaction 
                                                RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                                WHERE tbl_transaction.don_project_id = $id
                                                ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                                <tr>
                                                   
                                                    <td style="text-align: left;">'.$row['dv_name'].'</td>
                                                    <td style="text-align: left;">&#8369;'.number_format($row['amount']).'</td>
                                                    <td style="text-align: left;">'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                    <td style="text-align: left;">'.$row['transaction_id'].'</td>
                                                    <td style="text-align: left;">';
                                                    if ($row['stat'] == 'Verified') {
                                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                                } elseif ($row['stat'] == 'Pending') {
                                                    echo '<p style="color: orange">'.$row['stat'].'</p>';
                                                } elseif ($row['stat'] == 'Invalid') {
                                                    echo '<p style="color: red">'.$row['stat'].'</p>';
                                                }
                                            echo '</td>
                                                <td style="text-align: left;"><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                                </tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>     
                        </div>
                        <div class="tab-pane fade" id="verified-tab-pane" role="tabpanel" aria-labelledby="verified-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                              
                                        <th scope="col" style="width: 20%; text-align: left;">Name</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Amount</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Date</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Transaction ID</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Status</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                                FROM tbl_transaction 
                                                RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                                WHERE tbl_transaction.don_project_id = $id AND stat = 'Verified'
                                                ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                            <tr>
                                               
                                                <td style="text-align: left;">'.$row['dv_name'].'</td>
                                                <td style="text-align: left;">&#8369;'.number_format($row['amount']).'</td>
                                                <td style="text-align: left;">'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                <td style="text-align: left;">'.$row['transaction_id'].'</td>
                                                <td style="text-align: left;">';
                                                if ($row['stat'] == 'Verified') {
                                                    echo '<p style="color: green">'.$row['stat'].'</p>';
                                                }
                                                echo '</td>
                                                <td style="text-align: left;"><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                            </tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                       
                                        <th scope="col" style="width: 20%; text-align: left;">Name</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Amount</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Date</th>
                                        <th scope="col" style="width: 15%; text-align: left;">Transaction ID</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Status</th>
                                        <th scope="col" style="width: 10%; text-align: left;">Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <?php
                                        $sql4 = "SELECT tbl_transaction.*, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS dv_name 
                                        FROM tbl_transaction 
                                        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id 
                                        WHERE tbl_transaction.don_project_id = $id AND stat = 'Pending'
                                        ";
                                        $result2 = mysqli_query($conn, $sql4);
                                        while ($row = mysqli_fetch_array($result2)){
                                            echo '
                                            <tr>
                                               
                                                <td style="text-align: left;">'.$row['dv_name'].'</td>
                                                <td style="text-align: left;">&#8369;'.number_format($row['amount']).'</td>
                                                <td style="text-align: left;">'.date('F j, Y', strtotime($row['submitdate'])).'</td>
                                                <td style="text-align: left;">'.$row['transaction_id'].'</td>
                                                <td style="text-align: left;">';
                                                if ($row['stat'] == 'Pending') {
                                                    echo '<p style="color: orange">'.$row['stat'].'</p>';
                                                }
                                                echo '</td>
                                                <td style="text-align: left;"><a href="don_trans_details.php?transac_id='.$row['transac_id'].'&id='.$id.'"><button type="button" class="btn btn-info">Details</button></td>
                                            </tr>
                                            ';
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
