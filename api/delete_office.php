<?php
    include "../database/connection.php";
    // check if the data is set
    if(isset($_GET["office_id"])){
        $office_id = (int)$_GET["office_id"];
        // check if the office id is numeric
        if(is_numeric($office_id)){
           try{
            // preparing the office deletion
            $query = "DELETE FROM tbl_office WHERE office_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "i", $office_id);
            $response = mysqli_stmt_execute($stmt);
            // check if the response is true
            if($response){
                header("Location: ../pages/Office.php?success=Office successfully deleted");
                exit();
            }
            else{
                header("Location: ../pages/Office.php?error=Failed to delete office, Please try again!");
                exit();
            }
           }
           catch(Exception $error){
            // If the office is currently used by the employee then display the error message
            header("Location: ../pages/Office.php?error=Cannot delete office data. The office is currently in use by employees. Please remove associated employees before deleting the office.");
            exit();
           }
        }else{
            header("Location: ../pages/Office.php?error=Failed to delete Office");
            exit();
        }
    }
?>