<?php

$conn = mysqli_connect('localhost', 'root', '', 'dora') or die('connection failed');

// PayPal API Credentials
$paypalClientId = 'ARLzF28pjjMt2Q8PQKBUzhTsQxYH2aosjtLF76i8_QoJ70W_Li0EXPDiKN1lWkWmnB43EPVK82HsB7-O';
$paypalSecret = 'ARLzF28pjjMt2Q8PQKBUzhTsQxYH2aosjtLF76i8_QoJ70W_Li0EXPDiKN1lWkWmnB43EPVK82HsB7-O';

// Set the timezone to Philippine Time (Asia/Manila)
date_default_timezone_set('Asia/Manila');

?>

