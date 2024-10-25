<?php
include 'includes/config.php';

$id = $_GET['id']; 

// SQL query to retrieve applicants' details
$sql = "SELECT *
        FROM tbl_applicants
        RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
        WHERE tbl_applicants.assistance_id = $id
        AND stat = 'Verified'";

$result = $conn->query($sql);

// Assistance Proj Details and Beneficiary Count
$sql1 = "SELECT a.*, CONCAT(sw.fname, ' ', sw.mname, ' ', sw.lname) AS sw_name, COUNT(ap.appli_id) AS beneficiary_count
FROM tbl_assistance a
RIGHT JOIN tbl_sw_accs sw ON a.sw_id = sw.sw_id
LEFT JOIN tbl_applicants ap ON a.assistance_id = ap.assistance_id
WHERE a.assistance_id = '$id' AND ap.stat = 'Verified'";

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
    <title>List of Benefeciaries</title>

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
                echo '<div class="table-container">';
                $rowCount = 0;
                $pagenumber = 0;
                $perPage = 20;
            
                if ($pagenumber === 1) {
                    $perPage = 20;
                } else if ($pagenumber > 1) {
                    $perPage = 40;
                }
            
                while ($row1) {
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
                        if ($pagenumber === 1) {
                            echo '
                                <div class="title-container">
                                    <a href="/assistance_projects.php?id=' . $id . '"><h3>' . $row1['title'] . '</h3></a>
                                    <p>Project by: ' . $row1['sw_name'] . '</p>';
            
                            $dateUploaded = date('F j, Y', strtotime($row1['uploadDate']));
                            $deadline = date('F j, Y', strtotime($row1['deadline']));
                            echo '<p>' . $dateUploaded . ' - ' . $deadline . '</p>';
                            echo '</div>';
            
                            echo '<div class="custom-row">
                                    <div class="custom-col">
                                        <p class="data">' . $row1['avail_slot'] . '</p>
                                        <p class="data-label">Available Slots</p>
                                    </div>
                                    <div class="custom-col">
                                        <p class="data">' . $row1['beneficiary_count'] . '</p>
                                        <p class="data-label">Verified Beneficiaries</p>
                                    </div>
                                </div>';
                        }
            
                        echo '<table>';
                        echo '<tr>';
                        echo '<th>No.</th>';
                        echo '<th>Name</th>';
                        echo '</tr>';
                    }
            
                    // Retrieve and display beneficiaries for this assistance project
                    $beneficiarySql = "SELECT CONCAT(tbl_appli_accs.fname, ' ', tbl_appli_accs.mname, ' ', tbl_appli_accs.lname) AS fullname
                                       FROM tbl_applicants
                                       RIGHT JOIN tbl_appli_accs ON tbl_applicants.appli_id = tbl_appli_accs.appli_id
                                       WHERE tbl_applicants.assistance_id = $id AND tbl_applicants.stat = 'Verified'";
            
                    $beneficiaryResult = $conn->query($beneficiarySql);
            
                    if ($beneficiaryResult && $beneficiaryResult->num_rows > 0) {
                        while ($beneficiaryRow = $beneficiaryResult->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . ($rowCount + 1) . '</td>';
                            echo '<td>' . $beneficiaryRow['fullname'] . '</td>';
                            echo '</tr>';
                            $rowCount++;
                        }
                    }
            
                    if ($rowCount % $perPage === 0 || $rowCount === $result->num_rows) {
                        // Close the table if we've reached $perPage rows or it's the last row
                        echo '</table>';
                        echo '<br><br><p style="text-align: right;"> Page ' . $pagenumber . ' </p><br>';
                    }
            
                    $row1 = $result1->fetch_assoc();
                }
            
                echo '</div>'; // Close the table-container
            } else {
                echo '<p>No beneficiaries for this assistance project.</p>';
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
