<?php
include "../database/connection.php";

// check if the request method is POST and if data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["position_id"])) {
    $position_id = (int)$_POST["position_id"];
    // check if the position is numeric
    if (is_numeric($position_id)) {

        // prepare the query
        $query = "SELECT * FROM tbl_position WHERE position_id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $position_id);
        $statement->execute();
        $result = $statement->get_result();

        // get the result number of rows and send the response
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
        echo json_encode(array("message" => "Office is Invalid."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}

$statement->close();
$connection->close();
