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
    <title>Donation Drives</title>
    <link rel="stylesheet" href="css\sidebar.css">

    
    <!-- CDN LINK -->
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<!-- TITLE BARS -->
<div class="header">
        <h3>DONATIONS</h3>
    </div>

  <div class="sidebar close">
    <div class="logo-details">
        <i  img src="images/dora.png" alt="doralogo"></i>
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
  <div class="profile-image">
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
  </li>
</ul>
  </div>
  <section class="home-section">
    <div class="home-content">
      <i class='bx bx-menu' ></i>
    </div>

    <!-- UPLOADED CONTENT -->
    <div class="container content">
      <div class="title">
          <h3>Donation Drives</h3>
      </div>

      <div class="row">
            <div class="col-lg-8">
              <!-- Donation Projects -->
              <?php 
                // Define the base SQL query
                $sql_base = "SELECT dp.*, 
                    (SELECT SUM(amount) 
                    FROM tbl_transaction t 
                    WHERE dp.don_project_id = t.don_project_id 
                    AND t.stat = 'Verified') AS total_donation 
                    FROM tbl_don_proj dp
                    WHERE 1 AND dp.sw_id = $sw_id"; 

                // Handle search input
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                    $sql_base .= " AND (title LIKE '%$search%' OR category LIKE '%$search%')";
                }

                // Handle project status filter
                if (isset($_GET['status']) && is_array($_GET['status']) && !empty($_GET['status'])) {
                    $statuses = array_map(function ($status) use ($conn) {
                        return mysqli_real_escape_string($conn, $status);
                    }, $_GET['status']);
                
                    // Check if 'Funded' status is included in the filter
                    $hasFundedStatus = in_array('FUNDED', $statuses);
                    $statuses_str = implode("','", $statuses);
                
                    if ($hasFundedStatus) {
                        // If 'Funded' is selected, include 'Completed' status in the filter
                        $sql_base .= " AND (proj_stat IN ('$statuses_str') OR proj_stat = 'COMPLETED')";
                    } else {
                        // If 'Funded' is not selected, proceed with the standard filter
                        $sql_base .= " AND proj_stat IN ('$statuses_str')";
                    }
                }

                // Handle category filter
                if (isset($_GET['category']) && is_array($_GET['category']) && !empty($_GET['category'])) {
                    $categories = array_map(function ($category) use ($conn) {
                        return mysqli_real_escape_string($conn, $category);
                    }, $_GET['category']);
                    $categories_str = implode("','", $categories);
                    $sql_base .= " AND category IN ('$categories_str')";
                }

                // Handle sorting
                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

                switch ($sort) {
                    case 'closest':
                        $sql_base .= "  ORDER BY 
                        (total_donation / dp.goal) DESC,
                        dp.start DESC";
                        break;                
                    case 'nearest':
                        $sql_base .= " ORDER BY dp.end ASC";
                        break;
                    default:
                        $sql_base .= " ORDER BY dp.don_project_id DESC";
                        break;
                }

                $req3 = mysqli_query($conn, $sql_base);

                if (!$req3) {
                    die("SQL Error: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($req3) == 0) {
                    // IF THERE IS NO CONTENT UPLOADED: DISPLAY THE FOLLOWING
                    echo "No Uploaded Content at this time";
                } else {
                    // IF THERE IS CONTENT UPLOADED: PROCEED
                    while ($row = mysqli_fetch_assoc($req3)) {
                        //COMPUTATION
                        $sql3 = "SELECT SUM(amount) 
                        FROM tbl_transaction 
                        WHERE don_project_id = '".$row['don_project_id']."' AND stat = 'verified'";
                        $result1 = mysqli_query($conn, $sql3); 
                        $row1 = mysqli_fetch_assoc($result1);
                        $donation = $row1['SUM(amount)']; 

                        //PROGRESS BAR
                        $percentage = ($donation / $row['goal']) * 100;

                        $remaining = $row['goal'] - $donation;
                        
                        // PENDING BADGE
                        $query = "SELECT COUNT(*) AS pending_count FROM tbl_transaction WHERE don_project_id = '".$row['don_project_id']."' AND stat = 'pending'";
                        $qresult = mysqli_query($conn, $query);
                        $rowpending = mysqli_fetch_assoc($qresult);

                        $badge = 0;

                        $pending_count = $rowpending['pending_count'];
                        
                        if($pending_count > 0){
                          $badge = 1; 
                        }

                        //RETRIVING OF INFO FROM THE DATABASE
                        echo ' 
                        <div class=card-item>
                            <div class="card mb-3" style="max-width: 730px;">
                                <div class="row no-gutters position-relative">
                                    <div class="col-md-5 mb-md-0">
                                        <img class="card-img" src="don_img/'.$row['image'].'">
                                    </div>
                                    <div class="col-md-7 p-4 pl-md-0">
                                        <div class="card-body">
                                            <p class="card-text"><small class="text-body-secondary">'.$row['category'].'</small></p>
                                            <h5 class="card-title">'.$row['title'].'</h5>
                                            <div class="box">
                                                <p class = "progress-raised">&#8369; '.number_format($donation).' raised </p>   
                                                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: '.$percentage.'%"></div>
                                                </div>'; if ($donation >= $row['goal']){
                                                  echo '<p class="progress-to-go">Goal Reached!</p>';
                                                }else{ echo '  
                                                <p class = "progress-to-go">&#8369; '.number_format($remaining).' to go </p> ';} echo '
                                            </div>
                                            <a href="donation-details.php?id='.$row['don_project_id'].'" class="stretched-link"></a>
                                        </div>
                                    </div>
                                </div>
                                '; if ($badge == 1){ echo '<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                  <span class="visually-hidden">New alerts</span>
                                </span> ';} echo'
                            </div>
                        </div>
                        
                        ';
                    }
                }
            ?>

            </div>

            <div class="col-md-4">
                <div class="search-box">
                    <form method="GET" action="">
                        <!-- Search input -->
                        <div class="mb-3">
                            <label for="search" class="form-label">Search</label>
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Project Status</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="ongoing" value="ON GOING" <?php if (isset($_GET['status']) && in_array('ON GOING', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="ongoing">On-going</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="pastdue" value="PAST DUE" <?php if (isset($_GET['status']) && in_array('PAST DUE', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="pastdue">Past Due</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="goalreached" value="GOAL REACHED" <?php if (isset($_GET['status']) && in_array('GOAL REACHED', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="goalreached">Goal Reached</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="funded" value="FUNDED" <?php if (isset($_GET['status']) && in_array('FUNDED', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="funded">Funded</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="completed" value="COMPLETED" <?php if (isset($_GET['status']) && in_array('COMPLETED', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="completed">Completed</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="status[]" id="pending" value="PENDING" <?php if (isset($_GET['status']) && in_array('PENDING', $_GET['status'])) echo 'checked'; ?>>
                                <label class="form-check-label" for="pending">Pending</label>
                            </div>
                        </div>


                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Category</label><br>
                            <?php
                            // Fetch categories from the database
                            $sql_categories = "SELECT DISTINCT category FROM tbl_don_proj";
                            $result_categories = mysqli_query($conn, $sql_categories);
                            while ($row_category = mysqli_fetch_assoc($result_categories)) {
                                $isChecked = (isset($_GET['category']) && in_array($row_category['category'], $_GET['category'])) ? 'checked' : '';
                                echo '<div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="category[]" id="' . $row_category['category'] . '" value="' . $row_category['category'] . '" ' . $isChecked . '>
                                        <label class="form-check-label" for="' . $row_category['category'] . '">' . $row_category['category'] . '</label>
                                    </div>';
                            }
                            ?>
                        </div>

                        <!-- Sorting -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="" <?php if (!isset($_GET['sort']) || $_GET['sort'] == '') echo 'selected'; ?>>Select Sorting</option>
                                <option value="closest" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'closest') echo 'selected'; ?>>Closest to Goal</option>
                                <option value="nearest" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'nearest') echo 'selected'; ?>>Nearest to Deadline</option>
                            </select>
                        </div>
                        <a href="current_donation.php" style="font-size: 14px; color: #777; font-style: italic; text-align: right;">Clear Filters</a><br><br>

                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Apply Filters</button> <br>
                        </div>
                    </form>
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
