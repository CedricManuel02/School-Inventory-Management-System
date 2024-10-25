<?php

include "../database/connection.php";
include "../utils/functions.php";
$routes = "";
// check if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"], $_POST["confirm_password"], $_POST["token"])) {
    // getting the token from the POST 
    $token = $_POST["token"];
    $new_password = validateData($_POST["new_password"]);
    $confirm_password = validateData($_POST["confirm_password"]);


    if (empty($new_password)) {
        $routes = "../pages/Reset_Password.php??token=$token&error= New password is required";
    } else if (empty($confirm_password)) {
        $routes = "../pages/Reset_Password.php??token=$token&error= Confirm password is required";
    } else if (empty($token)) {
        $routes = "../pages/Reset_Password.php??token=$token&error= Token is invalid";
    } else {
        // hash the token 
        $token_hash = hash("sha256", $token);

        // select the token hash from the employee table
        $query = "SELECT * FROM tbl_employee WHERE reset_token_hash = ?";

        $stmt = mysqli_prepare($connection, $query);

        mysqli_stmt_bind_param($stmt, "s", $token_hash);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $response = mysqli_fetch_assoc($result);

        // validate the response
        if ($response === null) { // if null return token not found
            $routes = "../pages/Reset_Password.php??token=$token&error=Token not found";
        } else if (strtotime($response["reset_token_expires_at"]) <= time()) {
            // if the expires_at is less than to the current time, then display the token expired
            $routes = "../pages/Reset_Password.php??token=$token&error=Token has expired";
        } else if (strlen($new_password) < 8) { // validate password length
            $routes = "../pages/Reset_Password.php??token=$token&error=Password length must be 8 characters long";
        } else if (!preg_match("/[a-z]/i", $new_password)) { // vallidate if the password contain one character
            $routes = "../pages/Reset_Password.php??token=$token&error=Password must contain atleast one character";
        } else if ($new_password !== $confirm_password) { // ifi password is not match
            $routes = "../pages/Reset_Password.php??token=$token&error= Password mismatch";
        } else {
            $password_salt = uniqid(); // generate new salt
            $hash_password = password_hash($new_password . $password_salt, PASSWORD_BCRYPT);// hash the password
            // Update the tbl employee password and resetting the token and expires at to null 
            $query = "UPDATE tbl_employee 
                      SET reset_token_hash = NULL, reset_token_expires_at = NULL, employee_password = ?, password_salt = ?
                      WHERE employee_id = ?";

            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssi", $hash_password, $password_salt, $response["employee_id"]);
            mysqli_stmt_execute($stmt);

            // if the query is successful 
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $routes = "../pages/Login.php?success=Password successfully reset";
            } else {
                $routes = "../pages/Reset_Password.php?token=$token&error=Something went wrong, Please try again";
            }
        }
    }
} else {
    $routes = "../pages/Reset_Password.php??token=$token&error= Something went wrong, Please try again";
}

header("Location: $routes");
exit();
