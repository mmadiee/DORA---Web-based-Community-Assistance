<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $chartQuery = "SELECT DATE_FORMAT(submitdate, '%Y-%m-%d') as date, SUM(amount) as amount FROM tbl_transaction WHERE stat = 'Verified' AND submitdate BETWEEN '$startDate' AND '$endDate' GROUP BY DATE_FORMAT(submitdate, '%Y-%m-%d')";

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
