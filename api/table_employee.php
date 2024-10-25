<?php
include "../database/connection.php";
// prepare the query
$query = "SELECT
            tbl_employee.employee_id,
            tbl_employee.employee_first_name,
            tbl_employee.employee_date_created,
            tbl_employee.employee_last_name,
            tbl_position.position_name,
            tbl_office.office_name
            FROM tbl_employee
            INNER JOIN tbl_office ON tbl_employee.office_id = tbl_office.office_id
            INNER JOIN tbl_position ON tbl_employee.position_id = tbl_position.position_id
            WHERE tbl_employee.is_deleted = 0 AND tbl_employee.roles_id = 2";
$result = mysqli_query($connection, $query);
// check if the result is true
if ($result) {
    // check the number of rows in the result
    if (mysqli_num_rows($result) > 0) {
        // loop through the result and get the result of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>          
                    <td id='name' scope='row' class='flex items-center gap-5 px-6 py-4 text-slate-500 font-medium whitespace-nowrap'>
                        " . htmlspecialchars($row["employee_last_name"]) . ", " . htmlspecialchars($row["employee_first_name"]) . "
                    </td>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["position_name"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["office_name"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime(htmlspecialchars($row["employee_date_created"]))) . "</td>
                    <td class='px-6 py-4'>
                        <button onclick='viewEmployee(" . htmlspecialchars($row["employee_id"]) . ")' class='text-blue-400 hover:underline mx-1'>View</button>
                        <button onclick='editEmployee(" . htmlspecialchars($row["employee_id"]) . ")' class='text-blue-400 hover:underline mx-1'>Edit</button>
                        <button onclick='deleteEmployee(" . htmlspecialchars($row["employee_id"] ) . ")' class='text-blue-400 hover:underline mx-1'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr class='bg-white border-b'><td colspan='6' class='py-3 text-center text-slate-400'>No data</td></tr>";
    }
    // free space
    mysqli_free_result($result);
} else {
    echo "<tr><td colspan='6'>Error: " . mysqli_error($connection) . "</td></tr>";
}
// clsoe connection
mysqli_close($connection);
