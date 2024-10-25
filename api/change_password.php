<?php
session_start();
include "../database/connection.php";
include "../utils/functions.php";

// Check if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"], $_POST["confirm_password"])) {

    // validate the data with validateData Function
    $employee_id = $_SESSION["employee_id"];
    $new_password = validateData($_POST["new_password"]);
    $confirm_password = validateData($_POST["confirm_password"]);
    
    // check if the employee id is numeric
    if (is_numeric($employee_id)) {
        // check if the password is same
        if ($new_password !== $confirm_password) {
            header("Location: ../pages/Reset_Profile_Password.php?error=Password not match");
            exit();
        } else if (strlen($new_password) < 8) { // validate the password length 
            header("Location: ../pages/Reset_Profile_Password.php?error=Password length must be 8 characters long");
            exit();
        } else if (!preg_match("/[a-z]/i", $new_password)) { // validate the password it must contain atleast one character
            header("Location: ../pages/Reset_Profile_Password.php?error=Password length must contain at least one character");
            exit();
        } else {

            $password_salt = uniqid(); // generating a random salt
            $employee_password = password_hash($new_password . $password_salt, PASSWORD_BCRYPT); // hashing the password
            $query = "UPDATE tbl_employee SET employee_password = ?, password_salt = ?, employee_date_updated = NOW() WHERE employee_id = ?";
            $stmt =  mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $employee_password, $password_salt, $employee_id);
            $response = mysqli_stmt_execute($stmt);
            if ($response > 0) {
                header("Location: ../pages/Profile.php?success=Successfully change your password");
                exit();
            } else {
                header("Location: ../pages/Reset_Profile_Password.php?success=Failed to change your password");
                exit();
            }
        }
    } else {
        header("Location: ../pages/Reset_Profile_Password.php?error=Failed to change password");
        exit();
    }
} else {
    header("Location: ../pages/Reset_Profile_Password.php?error=Failed to change password");
    exit();
}
