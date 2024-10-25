<?php
include "../database/connection.php";
// check if the employee id is set
if (isset($_GET["employee_id"])) {
    $is_deleted = 1; // DEFAULT Values for deleted employee
    $employee_id = (int)$_GET["employee_id"];
    if (is_numeric($employee_id)) {
        // Updating the employee table is_deleted 
        $query = "UPDATE tbl_employee SET is_deleted = ? WHERE employee_id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ii", $is_deleted, $employee_id);
        $response = mysqli_stmt_execute($stmt);
        
        if ($response) {
            header("Location: ../pages/Employee.php?success=Successfully deleted");
            exit();
        } else {
            header("Location: ../pages/Employee.php?error=Failed to delete employee");
            exit();
        }
    } else {
        echo "is not numeric";
    }
}
