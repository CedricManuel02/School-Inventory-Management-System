<?php
session_start();
include "../utils/functions.php";
include "../database/connection.php";
$routes = "";

// Check if email and password is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {
    
    $email = validateData($_POST["email"]);
    $password = validateData($_POST["password"]);

    if (empty($email)) {
        $routes = "../pages/Login.php?error=Please enter your email";
    } 
    else if (empty($password)) {
        $routes = "../pages/Login.php?error=Please enter your password";
    } else {
        // Select all employees information (position, roles, office)
        $query = "SELECT tbl_employee.*, tbl_position.position_name, tbl_roles.roles AS roles_name, tbl_office.office_name FROM tbl_employee
        INNER JOIN tbl_position ON tbl_employee.position_id = tbl_position.position_id
        INNER JOIN tbl_office ON tbl_employee.office_id = tbl_office.office_id
        INNER JOIN tbl_roles ON tbl_employee.roles_id = tbl_roles.roles_id
        WHERE tbl_employee.employee_email = ? AND tbl_employee.is_deleted = 0";

        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result); // fetching the single row

        // validate if the password is matches to the table password field
        if ($row && password_verify($password . $row["password_salt"], $row["employee_password"])) {

            // Setting the session of the user
            $_SESSION["employee_id"] = $row["employee_id"];
            $_SESSION["employee_name"] = $row["employee_last_name"] . ", " . $row["employee_first_name"];
            $_SESSION["employee_first_name"] = $row["employee_first_name"];
            $_SESSION["employee_last_name"] = $row["employee_last_name"];
            $_SESSION["employee_email"] = $row["employee_email"];
            $_SESSION["employee_roles"] = $row["roles_name"];
            $_SESSION["office_name"] = $row["office_name"];
            $_SESSION["position_name"] = $row["position_name"];

            /* Check if the remember me is checked and add cookies and set the time to 1 Hour, 
            if not checked remove the cookies*/
            if (isset($_POST["remember_me"]) && $_POST["remember_me"] === "on") {
                setcookie("email", $email, time() + 3600, "/");
                setcookie("remember_me", "on", time() + 3600, "/");
            } else {
                setcookie("email", "", time() - 3600, "/");
                setcookie("remember_me", "", time() + 3600, "/");
            }
            // verified the proper routes base on the roles
            $routes = ($row["roles_name"] === "Admin") ? "../pages/Item.php" : "../pages/ItemOwned.php";
        } else {
            $routes = "../pages/Login.php?error=Invalid email or password";
        }
    }
    header("Location: " . $routes);
    exit();
}
?>
