<?php
    include "../database/connection.php";
    // prepate the query
    $query = "SELECT * FROM tbl_position";
    $response = mysqli_query($connection, $query);

    // check if the response is true and loop through the response
    if($response){
        while($row = mysqli_fetch_assoc($response)){
            echo '<option value="' . $row["position_id"] . '">' .$row["position_name"] . '</option>';
        }
        mysqli_free_result($response);
    } else {
        echo "Error:" . mysqli_error($connection);
    }
    mysqli_close($connection);
?>
