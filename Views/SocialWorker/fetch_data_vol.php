<?php


include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sw_id = $_POST['sw_id'];

    $chartQuery = "SELECT DATE_FORMAT(submitteddate, '%Y-%m-%d') as date, COUNT(DISTINCT user_id) as volunteer_count
                   FROM tbl_volunteers v
                   JOIN tbl_vol_proj dp ON v.vol_proj_id = dp.vol_proj_id
                   WHERE stat = 'Verified' AND sw_id = $sw_id
                   AND submitteddate BETWEEN '$startDate' AND '$endDate'
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
