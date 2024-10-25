<?php
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sw_id = $_POST['sw_id'];

    // Prepare the SQL query to fetch donation data for the specified social worker and date range
    $chartQuery = "SELECT DATE_FORMAT(submitdate, '%Y-%m-%d') as date, SUM(amount) as amount 
                    FROM tbl_transaction t
                    JOIN tbl_don_proj dp ON t.don_project_id = dp.don_project_id
                    WHERE t.stat = 'Verified' AND dp.sw_id = $sw_id AND submitdate BETWEEN '$startDate' AND '$endDate' 
                    GROUP BY DATE_FORMAT(submitdate, '%Y-%m-%d')";

    $result = $conn->query($chartQuery);

    $data = [];

    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $amount = (int)$row['amount'];
        $data[] = [$date, $amount];
    }

    echo json_encode($data);
}
?>
