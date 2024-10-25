<?php
include "../database/connection.php";
// check if data is set
if (isset($_GET["category_id"])) {
    // assign category to variable
    $category_id = (int)$_GET["category_id"];

    // check if the category id is numeric
    if (is_numeric($category_id)) {
        try {
            // preparing the delete query
            $query = "DELETE FROM tbl_category WHERE category_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $category_id);
            $response = mysqli_stmt_execute($stmt);

            // if the response is true then delete and if not return failed to delete
            if ($response) {
                header("Location: ../pages/Category.php?success=Category successfully deleted");
                exit();
            } else {
                header("Location: ../pages/Category.php?error=Failed to delete category, Please try again!");
                exit();
            }
        } catch (Exception $error) {
            // If the category is currently used by the emmployee, it display an error message
            header("Location: ../pages/Category.php?error=Cannot delete category data. The category is currently in use by employees. Please remove associated employees before deleting the category.");
            exit();
        }
    } else {
        header("Location: ../pages/Category.php?error=Invalid category");
        exit();
    }
}
