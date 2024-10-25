<?php
    include "../database/connection.php";
    include "../utils/functions.php";
    // check if the data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["position_name"])){
        // validate the data
        $position_name = validateData($_POST["position_name"]);
        // check if the data is emmpty
        if(empty($position_name)){
            header("Location: ../pages/Position.php?error= Position is required");
            exit();
        }else{
            // prepare the query
            $query = "INSERT INTO tbl_position VALUES (null, ?, NOW())";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "s", $position_name);
            $response = mysqli_stmt_execute($stmt);

            if($response){
                header("Location: ../pages/Position.php?error= Position added successfully");
                exit();
            }
            else{
                header("Location: ../pages/Position.php?error= Failed to add Employee's");
            }
        }
    }
?>