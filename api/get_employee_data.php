<?php
include "../database/connection.php";

// check if the request method is POST and if data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["employee_id"])) {
    $employee_id = (int)$_POST["employee_id"];
    // check if employee id is numeric
    if (is_numeric($employee_id)) {
        // preparing the query for getting the employee data
        $query = "SELECT tbl_employee.*, tbl_position.*, tbl_office.*, tbl_roles.* 
                    FROM tbl_employee 
                    INNER JOIN tbl_position ON tbl_position.position_id = tbl_employee.position_id
                    INNER JOIN tbl_office ON tbl_office.office_id = tbl_employee.office_id
                    INNER JOIN tbl_roles ON tbl_roles.roles_id = tbl_employee.roles_id
                    WHERE tbl_employee.employee_id = ?";

        $statement = $connection->prepare($query);
        $statement->bind_param("i", $employee_id);
        $statement->execute();
        $result = $statement->get_result();

        // if result number of rows is greater than 0 encode the result
        if ($result->num_rows > 0) {
            $employee = $result->fetch_assoc();
            header("Content-Type: application/json");
            echo json_encode($employee);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Employee not found."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Employee is Invalid"));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}

$statement->close();
$connection->close();
