<?php
include "../database/connection.php";

// Check if the request methond is POST and if the data is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["category_id"])) {

    $category_id = (int)$_POST["category_id"];
    // check if category
    if (is_numeric($category_id)) {
        $query = "SELECT * FROM tbl_category WHERE category_id = ?";
        $statement = $connection->prepare($query);
        $statement->bind_param("i", $category_id);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $category = $result->fetch_assoc();
            header("Content-Type: application/json");
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Category not found."));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Category is Invalid."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Bad Request"));
}

$statement->close();
$connection->close();
