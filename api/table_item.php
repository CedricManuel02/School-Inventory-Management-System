<?php
include "../database/connection.php";

$item_condition_repair = "Repair"; // DEFAULT VALUES
$item_condition_transfer = "Transfer"; // DEFAULT VALUES
// prepare the query 
$query = "SELECT
            tbl_item.item_id,
            tbl_item.item_name,
            tbl_item.item_condition,
            tbl_item.item_date_created,
            tbl_employee.employee_first_name,
            tbl_employee.employee_last_name,
            tbl_position.position_name,
            tbl_category.category_name 
          FROM tbl_item
          INNER JOIN tbl_employee ON tbl_item.employee_id = tbl_employee.employee_id
          INNER JOIN tbl_category ON tbl_item.category_id = tbl_category.category_id
          INNER JOIN tbl_position ON tbl_employee.position_id = tbl_position.position_id
          WHERE tbl_item.item_condition NOT IN (?, ?)";

$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "ss", $item_condition_repair, $item_condition_transfer);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
// check if the result is true
if ($result) {
    // check if the result lenght
    if (mysqli_num_rows($result) > 0) {
        // loop through the result
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='bg-white border-b'>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_name"]) . "</td>
                    <th scope='row' class='flex items-center gap-5 px-6 py-4 font-medium text-slate-600 whitespace-nowrap'>
                        " . htmlspecialchars($row["employee_last_name"]) . ", " . htmlspecialchars($row["employee_first_name"]) . "
                    </th>
                    <td class='px-6 py-4 text-slate-400'>" .htmlspecialchars($row["position_name"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["category_name"]) . "</td>
                    <td class='px-6 py-4 font-semibold " . (htmlspecialchars($row['item_condition']) == 'Repair' ? 'text-orange-500' : (htmlspecialchars($row['item_condition']) == 'Working' ? 'text-green-500' : 'text-red-500')) . "'>" . htmlspecialchars($row["item_condition"]) . "</td>
                    <td class='px-6 py-4 text-slate-400'>" . date('M d, Y', strtotime(htmlspecialchars($row["item_date_created"]))) . "</td>
                    <td class='px-6 py-4'>
                        <button onclick='viewItem(" . htmlspecialchars($row["item_id"]) . ")' class='text-blue-400 hover:underline mx-1'>View</button>
                        <button " . (htmlspecialchars($row["item_condition"]) != "Condemed" ? "onclick='editItem(" .htmlspecialchars($row["item_id"]) . ")' class='text-blue-400 hover:underline mx-1 cursor-pointer'" : "class='text-blue-400 hover:underline mx-1 cursor-not-allowed'") . ">Edit</button>
                        <button " . (htmlspecialchars($row["item_condition"]) != "Condemed" ? "onclick='deleteItem(" .htmlspecialchars($row["item_id"]) . ")' class='text-blue-400 hover:underline mx-1 cursor-pointer'" : "class='text-blue-400 hover:underline mx-1 cursor-not-allowed'") . ">Delete</button>
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

mysqli_close($connection);
?>
