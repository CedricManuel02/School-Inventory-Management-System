<?php
include "../database/connection.php";

$array_status = array("Accepted", "Rejected");
// check if session is set
if (isset($_SESSION["employee_id"])) {
    // prepare query 
    $query = "SELECT tbl_request.*, tbl_item.*
                FROM tbl_request
                INNER JOIN tbl_item ON tbl_request.item_id = tbl_item.item_id
                WHERE tbl_item.employee_id = ? AND tbl_request.request_status != '' OR tbl_request.request_status = NULL";

    $employee_id = (int)$_SESSION["employee_id"];
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $employee_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // check if the result is true
    if ($result) {
        // get the lenght of the result 
        if (mysqli_num_rows($result) > 0) {
            // loop through the result and get the attribute values
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr class='bg-white border-b'>
                        <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_name"]) . "</td>
                        <td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime(htmlspecialchars($row["request_date_created"]))) . "</td>
                        <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_condition"]) . "</td>
                        <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["request_status"]) . "</td>
                        <td class='px-6 py-4'>";

                // check if the request status is accepted or rejected
                if (in_array($row["request_status"], $array_status)) {
                    echo "<button onclick='requestButton(" . $row["request_id"] . ", " . $row["item_id"] . ", \"" . $row["item_condition"] . "\")' class='hover:bg-blue-500 mx-1 bg-blue-400 text-white px-2 py-1 rounded'>Done</button>";
                }
                echo "</td></tr>";
            }
        } else {
            echo "<tr class='bg-white border-b'><td colspan='7' class='py-3 text-center text-slate-400'>No data</td></tr>";
        }
        // free space
        mysqli_free_result($result);
    } else {
        echo "<tr><td colspan='6'>Error: " . htmlspecialchars(mysqli_error($connection)) . "</td></tr>";
    }
} else {
    header("Location: ../pages/Login.php?error=Session Expired");
    exit();
}

// close connection
mysqli_close($connection);
