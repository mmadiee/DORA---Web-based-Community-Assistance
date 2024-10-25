<?php include 'includes/config.php';?>
<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation</title>

    <link rel="stylesheet" href="css/donation.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/icon/favicon-16x16.png">
    <link rel="manifest" href="img/icon/site.webmanifest">

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
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="donation.php">Donations</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="volunteer.php">Volunteers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="assistance.php">Assistance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- DEFAULT CONTENT OF GUEST VIEW -->
    <div class="header">
        <h1>Donation</h1>
    </div>

    <div class="container content">
        <div class="title">
            <h3>On-going Donation Drives</h3>
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
                    WHERE dp.proj_stat = 'ON GOING'";

                    // Handle search input
                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                        $sql_base .= " AND (title LIKE '%$search%' OR category LIKE '%$search%')";
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
                            $sql_base .= " ORDER BY dp.start DESC";
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
                            $sql3 = "SELECT SUM(amount) FROM tbl_transaction WHERE don_project_id = '".$row['don_project_id']."' AND stat = 'verified'";
                            $result1 = mysqli_query($conn, $sql3); 
                            $row1 = mysqli_fetch_assoc($result1);
                            $donation = $row1['SUM(amount)']; 

                            //PROGRESS BAR
                            $percentage = ($donation / $row['goal']) * 100;

                            $remaining = $row['goal'] - $donation;

                            //RETRIVING OF INFO FROM THE DATABASE
                            echo ' 
                            <div class=card-item>
                                <div class="card mb-3" style="max-width: 730px;">
                                    <div class="row no-gutters position-relative">
                                        <div class="col-md-5 mb-md-0">
                                            <img class="card-img" src="Views\SocialWorker\don_img/'.$row['image'].'">
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
                                                <a href="donation_projects.php?id='.$row['don_project_id'].'" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    </div>
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

                        <!-- Category filter using checkboxes -->
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

                        <!-- Sorting dropdown -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="" <?php if (!isset($_GET['sort']) || $_GET['sort'] == '') echo 'selected'; ?>>Select Sorting</option>
                                <option value="closest" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'closest') echo 'selected'; ?>>Closest to Goal</option>
                                <option value="nearest" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'nearest') echo 'selected'; ?>>Nearest to Deadline</option>
                            </select>
                        </div>
                        <a href="donation.php" style="font-size: 14px; color: #777; font-style: italic; text-align: right;">Clear Filters</a><br><br>

                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Apply Filters</button> <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


 <!--FOOTER-->
    <footer class="sticky-footer">
        <!-- <h2>Footer Stick to the Bottom</h2> -->
        <ul>
            <li><a href="about.php">About</a></li>
            <li><a href="donation.php">Donations</a></li>
            <li><a href="volunteer.php">Volunteers</a></li>
            <li><a href="assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>