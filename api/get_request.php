<?php
    include "./database/connection.php";
    // prepare the query
    $query = "SELECT * FROM tbl_request";
    $response = mysqli_query($connection, $query);
    // if the response is true then loop through the response
    if($response){
        while($row = mysqli_fetch_assoc($response)){
            echo '<option value="'.$row["request_id"].'">' .$row["request_status"] . '</option>';
        }
        mysqli_free_result($response);
    } else {
        echo "Error:" . mysqli_error($connection);
    }
    mysqli_close($connection);
?>