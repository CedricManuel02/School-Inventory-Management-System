<?php
include "../database/connection.php";

// check if the request method is POST and the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["item_id"])) {
    $item_id = (int)$_POST["item_id"];

    // preparing the query 
    $query = "SELECT tbl_item.*, tbl_employee.*, tbl_category.* FROM tbl_item
                INNER JOIN tbl_employee ON tbl_item.employee_id = tbl_employee.employee_id
                INNER JOIN tbl_category ON tbl_category.category_id = tbl_item.category_id 
                WHERE item_id = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("i", $item_id);
    $statement->execute();
    $result = $statement->get_result();

    // check if the number of results is greater than 0, and send the result
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
    echo json_encode(array("message" => "Bad Request"));
}

$statement->close();
$connection->close();
?>
