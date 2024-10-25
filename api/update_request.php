<?php
include "../database/connection.php";
include "../utils/functions.php";

$array_status = array("Accepted", "Rejected");
//  check if the data is set
if (isset($_GET["item_id"]) && isset($_GET["request_id"]) && isset($_GET["request_status"])) {

    $item_id = (int)$_GET["item_id"];
    $request_id = (int)$_GET["request_id"];
    $request_status = validateData($_GET["request_status"]);

    // Sanitized the data
    if (is_numeric($item_id) && is_numeric($request_id) && in_array($request_status, $array_status)) {
        // prepare the query
        $query = "UPDATE tbl_request SET request_status = ? WHERE request_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "si", $request_status, $request_id);
        mysqli_stmt_execute($stmt);

        // Check if any rows were affected
        $affected_rows = mysqli_stmt_affected_rows($stmt);
        if ($affected_rows > 0) {
            header("Location: ../pages/Request.php?success=Successfully updated request");
            exit();
        } else {
            header("Location: ../pages/Request.php?error=No rows were updated");
            exit();
        }
    } else {
        header("Location: ../pages/Request.php?error=Invalid request status");
        exit();
    }
} else {
    header("Location: ../pages/Request.php?error=Missing request_id or request_status");
    exit();
}
?>
