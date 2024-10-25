<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $chartQuery = "SELECT DATE_FORMAT(submit_date, '%Y-%m-%d') as date, COUNT(DISTINCT sw_id) as sw_count
                   FROM tbl_sw_accs
                   WHERE status = 'verified' AND submit_date BETWEEN '$startDate' AND '$endDate'
                   GROUP BY DATE_FORMAT(submit_date, '%Y-%m-%d')";

    $result = $conn->query($chartQuery);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $date = date('F j, Y', strtotime($row['date']));  // Format date as "Month Day, Year"
        $SWCount = (int)$row['sw_count'];
        $data[] = [$date, $SWCount];
    }

    echo json_encode($data);
}
?>
