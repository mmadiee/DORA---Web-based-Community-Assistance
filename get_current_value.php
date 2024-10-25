<?php
// Make a database connection and retrieve the current donation value
$id = 117;
$db = mysqli_connect("localhost", "root", "", "dora");

$sql = "SELECT SUM(amount) as total FROM tbl_transaction WHERE don_project_id = $id AND stat = 'verified'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_assoc($result);
$currentValue = $row['total'];

// Return the current value as a JSON-encoded string
$response = array('currentValue' => $currentValue);
echo json_encode($response);
?>