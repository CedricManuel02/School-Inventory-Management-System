<?php
include "../database/connection.php";

// Check if the request is a POST method and if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["office_id"])) {
    $office_id = (int)$_POST["office_id"];
    // preparing the query 
    $query = "SELECT * FROM tbl_office WHERE office_id = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("i", $office_id);
    $statement->execute();
    $result = $statement->get_result();

    // check if the result is number of rows is greater than to 0 and sent the response
    if ($result->num_rows > 0) {   
        $office = $result->fetch_assoc();
        header("Content-Type: application/json");
        echo json_encode($office);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Office not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}

$statement->close();
$connection->close();
