<?php
include "../database/connection.php";
include "../utils/functions.php";
// check is data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["employee_first_name"], $_POST["employee_last_name"], $_POST["employee_email"], $_POST["position_id"], $_POST["office_id"], $_POST["roles_id"])) {

    $position_id = (int)$_POST["position_id"];
    $office_id = (int)$_POST["office_id"];
    $roles_id = (int)$_POST["roles_id"];
    $employee_first_name = validateData($_POST["employee_first_name"]);
    $employee_last_name = validateData($_POST["employee_last_name"]);
    $employee_email = validateData($_POST["employee_email"]);

    // check if the employee email is existing in the current table
    $query = "SELECT * FROM tbl_employee WHERE employee_email = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "s", $employee_email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        header("Location: ../pages/Employee.php?error=Email already exists");
        exit();
    }

    if (empty($employee_first_name)) {
        header("Location: ../pages/Employee.php?error=First Name is required");
        exit();
    } else if (empty($employee_last_name)) {
        header("Location: ../pages/Employee.php?error=Last Name is required");
        exit();
    } else if (empty($employee_email)) {
        header("Location: ../pages/Employee.php?error=Email is required");
        exit();
    } else if (empty($position_id) && is_numeric($position_id)) {
        header("Location: ../pages/Employee.php?error=Position is required");
        exit();
    } else if (empty($office_id) && is_numeric($office_id)) {
        header("Location: ../pages/Employee.php?error=Office is required");
        exit();
    } else if (empty($roles_id) && is_numeric($roles_id)) {
        header("Location: ../pages/Employee.php?error=Roles is required");
        exit();
    } else if (!filter_var($employee_email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../pages/Employee.php?error=Email is invalid");
        exit();
    } else {
        $is_deleted = 0; // DEFAULT VALUE
        $password_salt = uniqid(); // generate a random salt
        $employee_password = $employee_first_name . $employee_last_name; // Password with combined first and last name
        $hash_password = password_hash($employee_password . $password_salt, PASSWORD_BCRYPT); // encrypted password using BCRYPT algorithm
        // prepare query
        $query = "INSERT INTO tbl_employee VALUES (null,?,?,?,?,?,?,?, NOW(), null, null, ?, ?, NULL, NULL)";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "iissssiis", $position_id, $office_id, $employee_first_name, $employee_last_name, $employee_email, $hash_password, $is_deleted, $roles_id, $password_salt);
        $response = mysqli_stmt_execute($stmt);

        if ($response) {
            header("Location: ../pages/Employee.php?success=Employee added successfully");
            exit();
        } else {
            header("Location: ../pages/Employee.php?error=Failed to add Employee's");
            exit();
        }
    }
} else {
    header("Location: ../pages/Employee.php?error=Product data not found");
    exit();
}
