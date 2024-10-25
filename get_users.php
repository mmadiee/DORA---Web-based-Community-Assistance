<?php
header("Content-Type: application/json");
include('includes/config.php');

if (isset($_GET['sw_id'])) {
    // Sanitize the input to prevent SQL injection
    $sw_id = mysqli_real_escape_string($conn, $_GET['sw_id']);

    // Query to retrieve details based on the sw_id
    $sql = "SELECT * FROM tbl_sw_accs WHERE sw_id = '$sw_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            echo json_encode(array("status" => "success", "data" => $row));
        } else {
            echo json_encode(array("status" => "error", "message" => "No data found for the specified sw_id"));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "sw_id parameter is missing"));
}

mysqli_close($conn);
?>
