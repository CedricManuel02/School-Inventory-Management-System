<?php
    include "../database/connection.php";
    include "../utils/functions.php";
    // check if the request method is POST and if data is set
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["office_edit_id"], $_POST["office_edit_name"]))
    {
        // assign data into variables
        $office_id = (int)$_POST["office_edit_id"];
        $office_name = validateData($_POST["office_edit_name"]);

        // check if the id is numeric
        if(is_numeric($office_id)){
            // prepare the query
            $query = "UPDATE tbl_office SET office_name = ? WHERE office_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "si", $office_name, $office_id);
            $success = mysqli_stmt_execute($stmt);
            
            if ($success > 0) {
                header("Location: ../pages/Office.php?success=Successfuly updated office");
                exit();
            }else{
                header("Location: ../pages/Office.php?error=Failed to updated office, Please try again!");
                exit();
            }
        }else{
            header("Location: ../pages/Office.php?error=Something went wrong");
            exit();
        }
    }else{
        header("Location: ../pages/Office.php?error=Something went wrong");
        exit();
    }
?>