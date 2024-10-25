<?php
include 'includes/config.php';

// Start the session to be able to access session variables
session_start();

// Retrieve transaction details from the POST request
$data = json_decode(file_get_contents("php://input"));

if (!empty($data)) {
    // Retrieve transaction details from the POST request
    $donationAmount = $data->donation_amount;
    $donProjectId = $data->don_project_id;
    $transactionId = $data->transaction_id;

    // Get the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Insert transaction details into the database
    $sql = "INSERT INTO tbl_transaction (don_project_id, user_id, amount, transaction_id, stat, submitdate) VALUES 
    ('$donProjectId', '$user_id', '$donationAmount', '$transactionId', 'Verified', NOW())";
    
    // Perform the database query
    if ($conn->query($sql) === TRUE) {
        echo 'Transaction Completed';
    } else {
        echo 'Error inserting data into the database: ' . $conn->error;
    }
} else {
    echo 'Invalid data';
}
?>
