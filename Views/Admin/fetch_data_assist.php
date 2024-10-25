<?php


include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $chartQuery = "SELECT DATE_FORMAT(submitteddate, '%Y-%m-%d') as date, COUNT(DISTINCT appli_id) as beneficiary_count 
                  FROM tbl_applicants 
                  WHERE stat = 'Verified' 
                  AND DATE(submitteddate) BETWEEN '$startDate' AND '$endDate' 
                  GROUP BY DATE_FORMAT(submitteddate, '%Y-%m-%d')";

    $result = $conn->query($chartQuery);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $date = date('F Y', strtotime($row['date']));  // Format to include month names
        $beneficiaryCount = (int)$row['beneficiary_count'];
        $data[] = [$date, $beneficiaryCount];
    }

    echo json_encode($data);
}
?>
