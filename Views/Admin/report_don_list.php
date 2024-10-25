<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
include 'includes/config.php';

$id = $_GET['id']; 

// SQL query to retrieve transaction details
$sql = "SELECT tbl_transaction.transac_id, tbl_transaction.transaction_id, CONCAT(tbl_dv_accs.fname, ' ', tbl_dv_accs.lname) AS name, tbl_transaction.amount, tbl_transaction.submitdate AS date
        FROM tbl_transaction
        RIGHT JOIN tbl_dv_accs ON tbl_transaction.user_id = tbl_dv_accs.user_id
        WHERE tbl_transaction.don_project_id = $id AND stat = 'Verified'";

$result = $conn->query($sql);

// Donation Details, Amount, and Donor Count
$sql1 = "SELECT dp.title AS title, dp.goal AS goal, dp.start AS start, dp.end AS end, CONCAT(sw.fname, ' ', sw.lname) AS sw_name, SUM(t.amount) AS total_donation, COUNT(t.transac_id) AS donor_count
        FROM tbl_don_proj dp
        RIGHT JOIN tbl_sw_accs sw ON dp.sw_id = sw.sw_id
        LEFT JOIN tbl_transaction t ON dp.don_project_id = t.don_project_id
        WHERE dp.don_project_id = $id AND t.stat = 'verified'";

$result1 = $conn->query($sql1);
$row1 = $result1->fetch_assoc();

$title = $row1['title'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\report.css">

    <!-- html2PDF library -->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <title><?php echo $title;?></title>

    <!--ICONS-->
    <link rel="apple-touch-icon" sizes="180x180" href="/img/icon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon/favicon-16x16.png">
    <link rel="manifest" href="/img/icon/site.webmanifest">
</head>
<body>

    <div class="download">
        <button onClick="generatePDF()" class="btn btn-primary">Download as PDF</button>
    </div>

    <div class="container" id="pdf-container">
        <div class="table-container">
        <?php
            if ($result && $result->num_rows > 0) {
                $rowCount = 0;
                $pagenumber = 0;
                $perPage = 20;

                if ($pagenumber === 1) {
                    $perPage = 20;
                } else if ($pagenumber > 1){
                    $perPage = 40;
                }

                while ($row = $result->fetch_assoc()) {
                    if ($rowCount % $perPage === 0) {
                        // Start a new page for every $perPage rows
                        if ($rowCount !== 0) {
                            echo '</table>';
                            echo '<div style="page-break-before: always;"></div>'; // Page break
                        }

                        echo'
                            <div class="header">
                                <img src="/dora_logo.png" alt="Website Logo">
                                <div>
                                    <h1>Development of Rural Areas</h1>
                                    <p>Email: projectsbydora@gmail.com</p>
                                    <p>Website: <a href="https://projectsbydora.com" target="_blank">www.projectsbydora.com</a></p>
                                </div>
                            </div>
                            <hr class="divider">
                        ';
                        $pagenumber++; // Increment the page number
                        if ($pagenumber === 1){
                            echo '
                            
                            <div class="title-container">
                                <a href="/donation_projects.php?id=' . $id . '"><h3>' . $row1['title'] . '</h3></a>
                                <p>Project by: ' . $row1['sw_name'] . '</p>';
                            
                            $dateUploaded = date('F j, Y', strtotime($row1['start']));
                            $deadline = date('F j, Y', strtotime($row1['end']));
                            echo '<p>' . $dateUploaded . ' - ' . $deadline . '</p>';
                            echo '</div>';

                            echo '<div class="custom-row">
                                    <div class="custom-col">
                                        <p class="data"> &#8369;' . number_format($row1['goal']) . '</p>
                                        <p class="data-label">Total Goal</p>
                                    </div>
                                    <div class="custom-col">
                                        <p class="data"> &#8369;' . number_format($row1['total_donation']) . '</p>
                                        <p class="data-label">Donations Raised</p>
                                    </div>
                                    <div class="custom-col">
                                        <p class="data">' . $row1['donor_count'] . '</p>
                                        <p class="data-label">Donors Count</p>
                                    </div>
                                </div>';
                            }

                        echo '<table>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Name</th>';
                        echo '<th>Amount</th>';
                        echo '<th>Submit Date</th>';
                        echo '</tr>';
                    }

                    $formattedDate = date('m/d/Y', strtotime($row['date']));
                    echo '<tr>';
                    echo '<td>' . ($rowCount + 1) . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td> &#8369; ' . number_format($row['amount']) . '</td>';
                    echo '<td>' . $formattedDate . '</td>';
                    echo '</tr>';

                    $rowCount++;

                    if ($rowCount % $perPage === 0 || $rowCount === $result->num_rows) {
                        // Close the table if we've reached $perPage rows or it's the last row
                        echo '</table>';
                        echo '<br><br><p style="text-align: right;"> Page ' . $pagenumber . ' </p><br>';
                    }
                }
            } else {
                echo '<p>No transactions.</p>';
            }
        ?>

        </div>
    </div>

    <script>
        function generatePDF() {
            const element = document.getElementById("pdf-container");

            // Get the project title from PHP and use it in the filename
            const projectTitle = "<?php echo $title; ?>";

            const options = {
                margin: 0,
                filename: projectTitle + '_report.pdf',
                image: { type: 'jpeg', quality: 0.7 },
                html2canvas: { scale: 3 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
            };

            html2pdf()
                .from(element)
                .set(options)
                .save();
        }
    </script>
</body>
</html>
