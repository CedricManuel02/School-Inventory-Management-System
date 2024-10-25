<?php
    include "../database/connection.php";
    include "../utils/functions.php";
    
    //check if the data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["category_name"])){
        $category_name = validateData($_POST["category_name"]);
        if(empty($category_name)){
            header("Location: ../pages/Position.php?error= Category is required");
            exit();
        }else{
            // prepare the query
            $query = "INSERT INTO tbl_category VALUES (null, ?, NOW())";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "s", $category_name);
            $response = mysqli_stmt_execute($stmt);

            if($response){
                header("Location: ../pages/Category.php?success= Category added successfully");
                exit();
            }
            else{
                header("Location: ../pages/Category.php?error= Failed to add Category");
            }
        }
    }
?>