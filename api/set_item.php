<?php
include "../database/connection.php";
include "../utils/functions.php";

//check if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["employee_id"], $_POST["category_id"], $_POST["item_name"], $_POST["item_amount"], $_POST["item_brand"], $_POST["item_serial_no"], $_POST["item_model_no"], $_POST["item_date_purchased"])) {
    $empty = ""; // DEFAULT VALUE
    $item_condition = "Working"; // DEFAULT VALUES

    // validate data
    $employee_id = validateData($_POST["employee_id"]);
    $category_id = validateData($_POST["category_id"]);
    $item_name = validateData($_POST["item_name"]);
    $item_amount = validateData($_POST["item_amount"]);
    $item_brand = validateData($_POST["item_brand"]);
    $item_serial_no = validateData($_POST["item_serial_no"]);
    $item_model_no = validateData($_POST["item_model_no"]);
    $item_date_purchased = validateData($_POST["item_date_purchased"]);
    // check if the required fields is 
    if (empty($employee_id) || empty($category_id) || empty($item_name) || empty($item_amount)) {
        header("Location: ../pages/Item.php?error=All fields are required");
        exit();
    }
    // prepare query
    $query = "INSERT INTO tbl_item VALUES (null,?,?,?,?,?,?,?,?,?, NOW(), null)";
    $stmt = mysqli_prepare($connection, $query);

    // Check if the category is equals to 2
    if ($category_id == 2) {
        mysqli_stmt_bind_param($stmt, "iisssssss", $employee_id, $category_id, $item_name, $empty, $empty, $empty, $item_amount, $item_condition, $item_date_purchased);
    } else {
        // check if the required fields are not empty
        if (empty($item_brand) || empty($item_model_no) || empty($item_serial_no)) {
            header("Location: ../pages/Item.php?error=All fields are required");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "iisssssss", $employee_id, $category_id, $item_name, $item_brand, $item_serial_no, $item_model_no, $item_amount, $item_condition, $item_date_purchased);
    }
    // execute the query 
    $success = mysqli_stmt_execute($stmt);
    if ($success) {
        header("Location: ../pages/Item.php?success=Item added successfully");
        exit();
    } else {
        header("Location: ../pages/Item.php?error=Failed to add Item");
        exit();
    }
} else {
    header("Location: ../pages/Item.php?error=Product data not found");
    exit();
}
