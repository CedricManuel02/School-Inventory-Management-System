<?php
    include "../database/connection.php";
    // prepare the query
    $query = "SELECT * FROM tbl_office";
    $response = mysqli_query($connection, $query);
    // check if the response is true then loop through the results
    if($response){
        while($row = mysqli_fetch_assoc($response)){
            echo '<option value="'.$row["office_id"].'">' .$row["office_name"] . '</option>';
        }
        mysqli_free_result($response);
    } else {
        echo "Error:" . mysqli_error($connection);
    }
    mysqli_close($connection);
?>