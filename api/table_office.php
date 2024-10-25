<?php
include "../database/connection.php";

// prepare the query
$query = "SELECT * from tbl_office";
$result = mysqli_query($connection, $query);

// check if the result is true
if ($result) {
    // check the number of results
    if (mysqli_num_rows($result) > 0) {
        // loop through the results
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
            <th scope='row' class='flex items-center gap-5 px-6 py-4 text-slate-500 font-medium whitespace-nowrap'>
                " . htmlspecialchars($row["office_name"]) ."
            </th>
            <td class='px-6 py-4 text-slate-400'>".date('M d, Y', strtotime(htmlspecialchars($row["office_date_created"])))."</td>
            <td class='px-6 py-4'>
                <button onclick='editOffice(".htmlspecialchars($row["office_id"]).")' class='text-blue-400 hover:underline mx-1'>Edit</button>
                <button onclick='deleteOffice(".htmlspecialchars($row["office_id"]).")' class='text-blue-400 hover:underline mx-1'>Delete</button>
            </td>
          </tr>";
        }
    } else {
        echo "<tr class='bg-white border-b'><td colspan='7' class='py-3 text-center text-slate-400'>No data</td></tr>";
    }
    // free space
    mysqli_free_result($result);
} else {
    echo "<tr><td colspan='3'>Error: " . mysqli_error($connection) . "</td></tr>";
}

mysqli_close($connection);