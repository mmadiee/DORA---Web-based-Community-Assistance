<?php
require_once 'includes/config.php';

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    // Fetch data 
    $sql = "SELECT v.volunteer_id, v.user_id, v.story, v.submitteddate, v.stat, CONCAT(d.fname, ' ', d.mname, ' ', d.lname) AS name, p.title
            FROM tbl_volunteers v
            JOIN tbl_dv_accs d ON v.user_id = d.user_id
            JOIN tbl_vol_proj p ON v.vol_proj_id = p.vol_proj_id
            WHERE v.stat = 'Verified' AND v.submitteddate BETWEEN '$startDate' AND '$endDate'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    if ($result) {
        // File name
        $filename = "Volunteers-Chart-Data_$startDate-to-$endDate.csv";

        $output = fopen('php://output', 'w');

        $header = array(
            'Volunteer ID',
            'User ID',
            'Name',
            'Project Name',
            'Story',
            'Submitted Date',
            'Status'
        );

        fputcsv($output, $header);

        while ($row = mysqli_fetch_assoc($result)) {
            // Date English format
            $formattedSubmitDate = date('F d, Y', strtotime($row['submitteddate']));

            $data = array(
                $row['volunteer_id'],
                $row['user_id'],
                $row['name'], 
                $row['title'],
                $row['story'],
                $formattedSubmitDate, 
                $row['stat'],
            );
            fputcsv($output, $data);
        }

        fclose($output);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Exit
        exit;
    } else {
        echo "Error fetching data from the database.";
    }
} else {
    echo "Date range not specified.";
}
?>
