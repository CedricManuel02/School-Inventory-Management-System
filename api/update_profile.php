<?php
session_start();
include "../database/connection.php";
include "../utils/functions.php";

// check if the data is set and if the request methos is post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["employee_first_name"], $_POST["employee_last_name"])) {
    // assign the data into variables
    $employee_id = (int)$_SESSION["employee_id"];
    $employee_first_name =  validateData($_POST["employee_first_name"]);
    $employee_last_name =  validateData($_POST["employee_last_name"]);

    // prepare query
    $query = "UPDATE tbl_employee SET employee_first_name = ?, employee_last_name = ?,  employee_date_updated = NOW() WHERE employee_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $employee_first_name, $employee_last_name,  $employee_id);
    $success = mysqli_stmt_execute($stmt);
    
    if ($success > 0) {
        // update the session data
          $_SESSION["employee_name"] = $employee_last_name . ", " . $employee_first_name;
          $_SESSION["employee_first_name"] = $employee_first_name;
          $_SESSION["employee_last_name"] = $employee_last_name;
          header("Location: ../pages/Profile.php?success=Successfuly updated profile");
          exit();
    } else {
        // Failed to execute the statement
        header("Location: ../pages/Profile.php?error=Failed to update profile");
        exit();
    }
} else {
    // Invalid or missing parameters
    header("Location: ../pages/Profile.php?error=Failed to update profile");
    exit();
}
?>
