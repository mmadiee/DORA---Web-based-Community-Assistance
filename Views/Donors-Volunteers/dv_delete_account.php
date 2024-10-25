<?php
session_start();

include 'includes/config.php';

$db = mysqli_connect("localhost", "root", "", "dora");
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (!$db) {
    echo "Error: Unable to connect to the database.";
    exit();
}

$deleteQuery = "DELETE FROM tbl_dv_accs WHERE user_id = $user_id";
$result = mysqli_query($db, $deleteQuery);

if ($result) {
    header('location: /DORA/login.php'); 
} else {
    echo "Error deleting account: " . mysqli_error($db);
}
mysqli_close($db);
?>
