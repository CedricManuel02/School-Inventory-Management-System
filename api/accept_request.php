<?php
include "../database/connection.php";
include "../utils/functions.php";
$router = "";

// check if the data is set
if (isset($_GET["request_id"], $_GET["item_id"], $_GET["item_condition"])) {

    $is_done = 1; // DEFAULT VALUE 
    $request_status = "";
    $item_id = (int)$_GET["item_id"];
    $request_id = (int)$_GET["request_id"];
    $item_condition_default = "Working";
    $item_condition = validateData($_GET["item_condition"]);

    // check if the data is numeric 
    if (is_numeric($request_id) && is_numeric($item_id)) {

        // Update the request item
        $query = "UPDATE tbl_request SET is_done = ?, request_status = ? WHERE request_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "isi", $is_done, $request_status, $request_id);
        $success_request = mysqli_stmt_execute($stmt);

        // if item condition is not equals to Condemed then don't update the item
        if ($item_condition !== "Condemed") {
            $query = "UPDATE tbl_item SET item_condition = ? WHERE item_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "si", $item_condition_default, $item_id);
            $success_item = mysqli_stmt_execute($stmt);

            if ($success_request && $success_item) {
                $router = "../pages/EmployeeRequest.php?success=Successfully updated";
            } else {
                $router = "../pages/EmployeeRequest.php?error=Failed to update request, please try again!";
            }
        } else {
            if ($success_request) {
                $router = "../pages/EmployeeRequest.php?success=Successfully updated";
            } else {
                $router = "../pages/EmployeeRequest.php?error=Failed to update request, please try again!";
            }
        }
    } else {
        header("Location: ../pages/EmployeeRequest.php?error=Invalid request or item ID");
        exit();
    }
} else {
    header("Location: ../pages/EmployeeRequest.php?error=Missing parameters");
    exit();
}

header("Location: $router");
exit();
?>
