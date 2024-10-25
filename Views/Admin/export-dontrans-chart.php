<?php
require_once 'includes/config.php';

if (isset($_GET['startDate']) && isset($_GET['endDate'])) {
    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];

    // Fetch data 
    $sql = "SELECT t.transac_id, t.user_id, t.amount, t.submitdate, t.stat, d.name, p.title
            FROM tbl_transaction t
            JOIN tbl_dv_accs d ON t.user_id = d.user_id
            JOIN tbl_don_proj p ON t.don_project_id = p.don_project_id
            WHERE t.stat = 'Verified' AND t.submitdate BETWEEN '$startDate' AND '$endDate'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error: " . mysqli_error($conn));
    }

    if ($result) {
        // File name
        $filename = "Donation-Transactions-Chart-Data_$startDate-to-$endDate.csv";

        $output = fopen('php://output', 'w');

        $header = array(
            'Transaction ID',
            'User ID',
            'Name',
            'Project Name',
            'Amount',
            'Submit Date',
            'Status'
        );

        fputcsv($output, $header);

        while ($row = mysqli_fetch_assoc($result)) {
            // Date English format
            $formattedSubmitDate = date('F d, Y', strtotime($row['submitdate']));

            $data = array(
                $row['transac_id'],
                $row['user_id'],
                $row['name'], 
                $row['title'],
                $row['amount'],
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
