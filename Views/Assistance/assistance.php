<?php include 'includes/config.php';?>
<?php 
session_start();
$appli_id = $_SESSION['appli_id'];

if(!isset($appli_id)){
   header('location:/login.php');
};

if(isset($_GET['logout'])){
   unset($appli_id);
   session_destroy();
   header('location:/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assistance</title>

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

    <!-- DEFAULT CONTENT OF GUEST VIEW -->
    <div class="header">
        <h1>Assistance</h1>
    </div>
    
    <div class="container content">
        
        <div class="title">
            <h3>Available Assistance</h3>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Assistance Projects -->
                <?php 

                // Define the base SQL query
                $sql_base = "SELECT a.*, 
                        (SELECT COUNT(DISTINCT appli_id) 
                        FROM tbl_applicants WHERE a.assistance_id = tbl_applicants.assistance_id 
                        AND stat = 'Verified') AS assist_count 
                        FROM tbl_assistance a
                        WHERE a.proj_stat = 'ON GOING'";

                // Handle search input
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = mysqli_real_escape_string($conn, $_GET['search']);
                    $sql_base .= " AND (a.title LIKE '%$search%' OR a.category LIKE '%$search%')";
                }

                // Handle category filter
                if (isset($_GET['category']) && is_array($_GET['category']) && !empty($_GET['category'])) {
                    $categories = array_map(function ($category) use ($conn) {
                        return mysqli_real_escape_string($conn, $category);
                    }, $_GET['category']);
                    $categories_str = implode("','", $categories);
                    $sql_base .= " AND a.category IN ('$categories_str')";
                }

                // Handle sorting
                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

                switch ($sort) {
                    case 'closest':
                        $sql_base .= "   ORDER BY 
                        (assist_count / a.avail_slot) DESC,
                        a.uploadDate DESC";
                        break;
                    case 'nearest':
                            $sql_base .= " ORDER BY a.deadline ASC";
                            break;
                    default:
                        $sql_base .= " ORDER BY a.uploadDate DESC";
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
                        //PROGRESS BAR
                        $percentage = ($row['assist_count'] / $row['avail_slot']) * 100;
                        $remaining = $row['avail_slot'] - $row['assist_count'];

                        //RETRIEVING INFO FROM THE DATABASE
                        echo ' 
                        <div class="card-item">
                            <div class="card mb-3" style="max-width: 730px;">
                                <div class="row no-gutters position-relative">
                                    <div class="col-md-5 mb-md-0">
                                        <img class="card-img" src="\Views\SocialWorker\assist_img/'.$row['image'].'">
                                    </div>
                                    <div class="col-md-7 position-static p-4 pl-md-0">
                                        <div class="card-body">
                                            <p class="card-text"><small class="text-body-secondary">'.$row['category'].'</small></p>
                                            <h5 class="card-title">'.$row['title'].'</h5>
                                            <div class="box">
                                                <p class="progress-raised">'.$row['assist_count'].' beneficiaries</p>   
                                                <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar" style="width: '.$percentage.'%"></div>
                                                </div>';

                        if ($row['assist_count'] >= $row['avail_slot']) {
                            echo '<p class="progress-to-go">Goal Reached!</p>';
                        } else {
                            echo '<p class="progress-to-go">'.$remaining.' to go</p>';
                        }

                        echo '
                                            </div>
                                            <a href="assistance_projects.php?id='.$row['assistance_id'].'" class="stretched-link"></a>
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
                            $sql_categories = "SELECT DISTINCT category FROM tbl_assistance";
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
                        <a href="assistance.php" style="font-size: 14px; color: #777; font-style: italic; text-align: right;">Clear Filters</a><br><br>

                        
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
            <li><a href="assistance.php">Assistance</a></li>
        </ul>
        <p> © Copyright DORA 2023.</p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>