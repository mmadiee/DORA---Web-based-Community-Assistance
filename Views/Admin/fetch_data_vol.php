<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $chartQuery = "SELECT DATE_FORMAT(submitteddate, '%Y-%m-%d') as date, COUNT(DISTINCT user_id) as volunteer_count
                   FROM tbl_volunteers
                   WHERE stat = 'Verified' AND submitteddate BETWEEN '$startDate' AND '$endDate'
                   GROUP BY DATE_FORMAT(submitteddate, '%Y-%m-%d')";

    $result = $conn->query($chartQuery);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $date = date('F j, Y', strtotime($row['date']));  // Format date as "Month Day, Year"
        $volunteerCount = (int)$row['volunteer_count'];
        $data[] = [$date, $volunteerCount];
    }

    echo json_encode($data);
}
?>
