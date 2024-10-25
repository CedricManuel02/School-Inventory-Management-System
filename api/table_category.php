<?php
include "../database/connection.php";

// prepar ethe query
$query = "SELECT * from tbl_category";
$result = mysqli_query($connection, $query);

// check if the result is true
if ($result) {
    // get the number of rows
    if (mysqli_num_rows($result) > 0) {
        // get the value of each data get from the mysqli_fetch_assoc then print the tr element
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
            <th scope='row' class='flex items-center gap-5 px-6 py-4 text-slate-500 font-medium whitespace-nowrap'>
                " . $row["category_name"] . "
            </th>
            <td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime($row["category_date_created"])) . "</td>
            <td class='px-6 py-4'>
                <button onclick='editCategory(" . $row["category_id"] . ")' class='text-blue-400 hover:underline mx-1'>Edit</button>
                <button onclick='deleteCategory(" . $row["category_id"] . ")' class='text-blue-400 hover:underline mx-1'>Delete</button>
            </td>
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
