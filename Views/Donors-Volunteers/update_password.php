<?php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);

    // Hash the new password using password_hash
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $sql = "UPDATE tbl_dv_accs SET password = '$hashedPassword' WHERE user_id = $user_id";

    if (mysqli_query($conn, $sql)) {
        echo "Password updated successfully.";
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

?>
