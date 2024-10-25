<?php
    include "../database/connection.php";
    include "../utils/functions.php";
    // Check if the request method is POST and if data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["position_edit_id"], $_POST["position_edit_name"]))
    {
        // assign the data into variables
        $position_id = (int)$_POST["position_edit_id"];
        $position_name = validateData($_POST["position_edit_name"]);

        // check if the id is numeric
        if(is_numeric($position_id)){
            // prepare the query
            $query = "UPDATE tbl_position SET position_name = ? WHERE position_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "si", $position_name, $position_id);
            $success = mysqli_stmt_execute($stmt);
            if ($success > 0) {
                header("Location: ../pages/Position.php?success=Successfuly updated position");
                exit();
            }else{
                header("Location: ../pages/Position.php?error=Failed to updated position, Please try again!");
                exit();
            }
        }else{
            header("Location: ../pages/Position.php?error=Something went wrong");
            exit();
        }
    }else{
        header("Location: ../pages/Position.php?error=Something went wrong");
        exit();
    }
?>