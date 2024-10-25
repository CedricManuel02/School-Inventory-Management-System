<?php
include "../database/connection.php";

// preparing the query
$query = "SELECT * FROM tbl_category";
$response = mysqli_query($connection, $query);
// check if the response is true
if ($response) {
    $first = true; // assign the first variable to true 
    while ($row = mysqli_fetch_assoc($response)) {
        $selected = $first ? 'selected' : ''; // if the first loop then set to selected , if not set to empty string
        echo '<option value="' . $row["category_id"] . '" ' . $selected . '>' . $row["category_name"] . '</option>';
        $first = false;
    }
    mysqli_free_result($response);
} else {
    echo "Error: " . mysqli_error($connection);
}
mysqli_close($connection);
?>
