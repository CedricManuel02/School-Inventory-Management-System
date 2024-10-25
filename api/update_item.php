<?php
include "../database/connection.php";
include "../utils/functions.php";

$routes = "";
$item_condition = "Condemed";

// Check if the request method is POST and required data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["employee_edit_id"], $_POST["category_edit_id"], $_POST["item_edit_name"], $_POST["item_edit_amount"], $_POST["item_edit_brand"], $_POST["item_edit_serial_no"], $_POST["item_edit_model_no"], $_POST["item_edit_date_purchased"], $_POST["item_id"])) {

    // Set data into variables
    $item_id = (int)$_POST["item_id"];
    $employee_id = validateData($_POST["employee_edit_id"]);
    $category_id = validateData($_POST["category_edit_id"]);
    $item_name = validateData($_POST["item_edit_name"]);
    $item_amount = validateData($_POST["item_edit_amount"]);
    $item_brand = validateData($_POST["item_edit_brand"]);
    $item_serial_no = validateData($_POST["item_edit_serial_no"]);
    $item_model_no = validateData($_POST["item_edit_model_no"]);
    $item_date_purchased = validateData($_POST["item_edit_date_purchased"]);

    // Validate if the data is empty
    if (empty($employee_id) || empty($category_id) || empty($item_name) || empty($item_amount) || empty($item_id)) {
        $routes = "../pages/Item.php?error=All fields are required";
    } else {
        // Check if the item id is numeric
        if (is_numeric($item_id)) {
            // Prepare the query
            $query = "UPDATE tbl_item 
                     SET employee_id = ?, category_id = ?, item_name = ?, item_amount = ?,  item_brand = ?, item_serial_no = ?, item_model_no = ?, item_date_purchased = ? 
                     WHERE item_id = ? AND item_condition != ?";
            $stmt = mysqli_prepare($connection, $query);

            if ($category_id == 2) {
                $empty = "";
                mysqli_stmt_bind_param($stmt, "iissssssss", $employee_id, $category_id, $item_name, $item_amount, $empty, $empty, $empty, $item_date_purchased, $item_id, $item_condition);
            } else {
                // Check if the required fields are not empty
                if (empty($item_brand) || empty($item_model_no) || empty($item_serial_no)) {
                    $routes = "../pages/Item.php?error=All fields are required";
                    header("Location: $routes");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "iissssssss", $employee_id, $category_id, $item_name, $item_amount, $item_brand, $item_serial_no, $item_model_no, $item_date_purchased, $item_id, $item_condition);
            }

            $success = mysqli_stmt_execute($stmt);

            if ($success > 0) {
                $routes = "../pages/Item.php?success=Item updated successfully";
            } else {
                $routes = "../pages/Item.php?error=Failed to update Item";
            }
        } else {
            $routes = "../pages/Item.php?error=Failed to update Item";
        }
    }
} else {
    $routes = "../pages/Item.php?error=Item data not found";
}

header("Location: $routes");
exit();
?>
