<?php
    include "../database/connection.php";
    include "../utils/functions.php";

    // check if the data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["office_name"])){
        // validate the data
        $office_name = validateData($_POST["office_name"]);

        //check if the data is empty
        if(empty($office_name)){
            header("Location: ../pages/Position.php?error= Office is required");
            exit();
        }else{
            // prepare the query
            $query = "INSERT INTO tbl_office VALUES (null, ?, NOW())";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "s", $office_name);
            $response = mysqli_stmt_execute($stmt);

            if($response){
                header("Location: ../pages/Office.php?success= Office added successfully");
                exit();
            }
            else{
                header("Location: ../pages/Office.php?error= Failed to add Office");
            }
        }
    }
?>