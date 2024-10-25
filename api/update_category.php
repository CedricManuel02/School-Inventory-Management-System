<?php
    include "../database/connection.php";
    include "../utils/functions.php";

    // Check if the request method is POST and data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["category_edit_id"], $_POST["category_edit_name"]))
    {
        $category_id = (int)$_POST["category_edit_id"];
        $category_name = validateData($_POST["category_edit_name"]);

        // check if the id is numeric
        if(is_numeric($category_id)){
            // prepare the query
            $query = "UPDATE tbl_category SET category_name = ? WHERE category_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "si", $category_name, $category_id);
            $success = mysqli_stmt_execute($stmt);
            if ($success > 0) {
                header("Location: ../pages/Category.php?success=Successfuly updated category");
                exit();
            }else{
                header("Location: ../pages/Category.php?error=Failed to updated category, Please try again!");
                exit();
            }
        }else{
            header("Location: ../pages/Category.php?error=Something went wrong");
            exit();
        }
    }else{
        header("Location: ../pages/Category.php?error=Something went wrong");
        exit();
    }
?>