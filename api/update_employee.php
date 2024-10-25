<?php
session_start();
include "../database/connection.php";
include "../utils/functions.php";
// check if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset(
    $_POST["employee_edit_first_name"],
    $_POST["employee_edit_last_name"],
    $_POST["position_edit_id"],
    $_POST["office_edit_id"],
    $_POST["roles_edit_id"],
    $_POST["employee_edit_id"]
)) {

    $roles_id = (int)$_POST["roles_edit_id"];
    $office_id = (int)$_POST["office_edit_id"];
    $employee_id =(int)$_POST["employee_edit_id"];
    $position_id = (int)$_POST["position_edit_id"];
    $employee_first_name =  validateData($_POST["employee_edit_first_name"]);
    $employee_last_name =  validateData($_POST["employee_edit_last_name"]);

    // Validate and sanitize the id
    if (is_numeric($employee_id) && is_numeric($position_id) && is_numeric($office_id) && is_numeric($roles_id)) {
        // prepare the update query
            $query = "UPDATE tbl_employee SET employee_first_name = ?, employee_last_name = ?, position_id = ?, office_id = ?, roles_id = ?, employee_date_updated = NOW() WHERE employee_id = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, "ssiiii", $employee_first_name, $employee_last_name, $position_id, $office_id, $roles_id, $employee_id);
            $success = mysqli_stmt_execute($stmt);
            if ($success > 0) {
                header("Location: ../pages/Employee.php?success=Successfuly updated Employee");
                exit();
            } else {
                header("Location: ../pages/Employee.php?error=Failed to update Employees");
                exit();
            }
    } else {
        // Failed to execute the statement
        header("Location: ../pages/Employee.php?error=Failed to update Employeess");
        exit();
    }
} else {
    // Invalid or missing parameters
    header("Location: ../pages/Employee.php?error=Failed to update Employeesss");
    exit();
}
