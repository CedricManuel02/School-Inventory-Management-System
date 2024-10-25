<?php
include "../database/connection.php";


// preparing the query
$query = "SELECT * FROM tbl_employee WHERE roles_id = 2 AND is_deleted = 0";
$result = mysqli_query($connection, $query);

// if the result is true
if ($result) {
    // get the number of rows affected from the result and incremented the number of rows 
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'.$row["employee_id"].'">' . $row["employee_first_name"] . ", ". $row["employee_last_name"] . '</option>';
        }
    } else {
        echo "<option value='' disabled>No data</option>";
    }
    mysqli_free_result($result);
} else {
    echo "<option value='' disabled>" . mysqli_error($connection) . "</option>";

}

mysqli_close($connection);