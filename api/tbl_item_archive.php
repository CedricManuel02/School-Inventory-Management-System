<?php
include "../database/connection.php";

// prepar ethe query
$query = "SELECT * from tbl_item WHERE employee_id = ? AND item_condition = 'Condemed'";
$stmt = mysqli_prepare($connection, $query);

if (!$stmt) {
    echo "<tr class='bg-white border-b'><td colspan='7' class='py-3 text-center text-slate-400'>Something went wrong</td></tr>";
}

mysqli_stmt_bind_param($stmt, "i", $_SESSION["employee_id"]);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// check if the result is true
if ($result) {
    // get the number of rows
    if (mysqli_num_rows($result) > 0) {
        // get the value of each data get from the mysqli_fetch_assoc then print the tr element
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
            <th scope='row' class='flex items-center gap-5 px-6 py-4 text-slate-500 font-medium whitespace-nowrap'>
                " . $row["item_name"] . "
            </th>
            <td class='px-6 py-4 text-slate-400'>" . $row["item_condition"] . "</td>
            <td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime($row["item_date_created"])) . "</td>
          </tr>";
        }
    } else {
        echo "<tr class='bg-white border-b'><td colspan='7' class='py-3 text-center text-slate-400'>No data</td></tr>";
    }
    // free the memory
    mysqli_free_result($result);
} else {
    echo "<tr><td colspan='3'>Error: " . mysqli_error($connection) . "</td></tr>";
}

mysqli_close($connection);
