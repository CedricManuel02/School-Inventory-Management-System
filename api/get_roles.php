<?php
    include "../database/connection.php";

    // prepare the query 
    $query = "SELECT * FROM tbl_roles";
    $response = mysqli_query($connection, $query);
    // check if the respobse is true and loop through the response
    if($response){
        while($row = mysqli_fetch_assoc($response)){
            echo '<option value="'.$row["roles_id"].'">' .$row["roles"] . '</option>';
        }
        mysqli_free_result($response);
    } else {
        echo "Error:" . mysqli_error($connection);
    }
    mysqli_close($connection);
?>