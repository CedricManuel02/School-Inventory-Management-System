<?php
include "../database/connection.php";

$request_status = "Pending"; // DEFAULT VALUE
// prepare query
$query = "SELECT tbl_request.*, tbl_employee.employee_first_name, 
            tbl_employee.employee_last_name,
            tbl_item.item_name,
            tbl_item.item_id,
            tbl_item.item_condition
            FROM tbl_request 
            INNER JOIN tbl_item ON tbl_request.item_id = tbl_item.item_id
            INNER JOIN tbl_employee ON tbl_item.employee_id = tbl_employee.employee_id WHERE request_status = ? AND tbl_employee.is_deleted = 0";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $request_status);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// check if the result is true
if ($result) {
    // check the length of result
    if (mysqli_num_rows($result) > 0) {
        // loop through the result and get each row attribute
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
                    <td class='px-6 py-4 text-slate-500 font-medium'>" . htmlspecialchars($row["employee_last_name"]) . ", " . htmlspecialchars($row["employee_first_name"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_name"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" .date('M d, Y', strtotime(htmlspecialchars($row["request_date_created"]))) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_condition"]) . "</td>
                    <td class='px-6 py-4'>
                        <a href='../api/update_request.php?item_id=" . urlencode($row["item_id"]) . "&request_id=" . urlencode($row["request_id"]) . "&request_status=Accepted' class='hover:bg-green-500 mx-1 bg-green-400 text-white px-2 py-1 rounded'>Accept</a>
                        <a href='../api/update_request.php?item_id=" . urlencode($row["item_id"]) . "&request_id=" . urlencode($row["request_id"]) . "&request_status=Rejected' class='hover:bg-red-500 mx-1 bg-red-400 text-white px-2 py-1 rounded'>Reject</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr class='bg-white border-b'><td colspan='7' class='py-3 text-center text-slate-400'>No data</td></tr>";
    }
    // free space
    mysqli_free_result($result);
} else {
    echo "<tr><td colspan='6'>Error: " . mysqli_error($connection) . "</td></tr>";
}
// close connection
mysqli_close($connection);
