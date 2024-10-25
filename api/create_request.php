<?php

include "../database/connection.php";
include "../utils/functions.php";

// set of string array status
$array_status = array("Repair", "Transfer", "Condemed");

// check if the data is set
if (isset($_GET["item_id"]) && isset($_GET["request_status"])) {
    
    $is_done = 0; //DEFAULT VALUE
    $request_status = "Pending"; // DEFAULT VALUE
    $item_id = (int)$_GET["item_id"];
    $item_condition = validateData($_GET["request_status"]);
    
    // check if the item id is numeric and if the item condition is contained into the array status 
    if (is_numeric($item_id) && in_array($item_condition, $array_status)) {

        // Preparing the query
        $query = "SELECT * FROM tbl_request WHERE item_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $item_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        /* check if the item exists in the tbl request 
            if yes just update the table request and if not insert new record
        */
        if (mysqli_num_rows($result) > 0) {
                $query = "UPDATE tbl_request SET request_status = ?, is_done = ?, request_date_created = NOW() WHERE item_id = ?";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "sii", $request_status, $is_done, $item_id);
          
        } else {
                $query = "INSERT INTO tbl_request (item_id, request_status, is_done, request_date_created) VALUES (?, ?, ?, NOW())";
                $stmt = mysqli_prepare($connection, $query);
                mysqli_stmt_bind_param($stmt, "isi", $item_id, $request_status, $is_done);
        }
        

        mysqli_stmt_execute($stmt);
        // Updating the table item conditions 
        $query = "UPDATE tbl_item SET item_condition = ? WHERE item_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "si", $item_condition, $item_id);
        mysqli_stmt_execute($stmt);

        header("Location: ../pages/ItemOwned.php?success=Successfully sent a request");
        exit();
    } else {
        header("Location: ../pages/ItemOwned.php?error=Invalid request status");
        exit();
    }
} else {
    header("Location: ../pages/ItemOwned.php?error=Failed to request item");
    exit();
}

?>
