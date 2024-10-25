<?php
include "../database/connection.php";

// prepare the query
$query = "SELECT position_id, position_name, position_date_created FROM tbl_position";
$result = mysqli_query($connection, $query);

// check if the result is true
if ($result) {
    // check the length of the result
    if (mysqli_num_rows($result) > 0) {
        // loop through the result row and get the attributes
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
                    <th scope='row' class='flex items-center gap-5 px-6 py-4 text-slate-500 font-medium whitespace-nowrap'>
                        " . htmlspecialchars($row["position_name"]) ."
                    </th>
                    <td class='px-6 py-4 text-slate-400'>".date('M d, Y', strtotime(htmlspecialchars($row["position_date_created"])))."</td>
                    <td class='px-6 py-4'>
                        <button onclick='editPosition(".htmlspecialchars($row["position_id"]).")' class='text-blue-400 hover:underline mx-1'>Edit</button>
                        <button onclick='deletePosition(".htmlspecialchars($row["position_id"]).")' class='text-blue-400 hover:underline mx-1'>Delete</button>
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

mysqli_close($connection);