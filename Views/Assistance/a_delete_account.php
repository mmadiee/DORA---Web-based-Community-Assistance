<?php
session_start();

// Include the database connection configuration
include 'includes/config.php';

if (!isset($_SESSION['appli_id'])) {
    // Redirect to the login page or any other appropriate page
    header('location: login.php');
    exit();
}


// Retrieve the appli_id from the session
$appli_id = $_SESSION['appli_id'];

if (!$conn) {
    // Handle the case where the database connection fails
    echo "Error: Unable to connect to the database.";
    exit();
}

$deleteQuery = "DELETE FROM tbl_appli_accs WHERE appli_id = $appli_id";
$result = mysqli_query($conn, $deleteQuery);

if ($result) {
    // Deletion was successful
    // You may want to redirect the user to a confirmation page or log them out
    header('location: /DORA/login_assistance.php'); // Create account_deleted.php as needed
} else {
    // Deletion failed, handle the error
    echo "Error deleting account: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
