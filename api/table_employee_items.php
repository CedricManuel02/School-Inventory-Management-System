<?php
include "../database/connection.php";

$item_condition = "Working"; // DEFAULT VALUE

// prepare query
$query = "SELECT tbl_item.*, tbl_category.category_name FROM tbl_item
          INNER JOIN tbl_category ON tbl_item.category_id = tbl_category.category_id
          WHERE employee_id = ? AND item_condition = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "is", $_SESSION["employee_id"], $item_condition);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// get the number of rows in the result 
if (mysqli_num_rows($result) > 0) {
    // loop through each data get 
    while ($row = mysqli_fetch_assoc($result)) {
        // use urlencode to encode the string and be able to use in the url
        $repairUrl = '../api/create_request.php?item_id=' . urlencode($row["item_id"]) . '&request_status=Repair';
        $transferUrl = '../api/create_request.php?item_id=' . urlencode($row["item_id"]) . '&request_status=Transfer';
        $condemnUrl = '../api/create_request.php?item_id=' . urlencode($row["item_id"]) . '&request_status=Condemed';

        echo "<tr class='bg-white border-b'>
                <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_name"]) . "</td>
                <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["item_brand"]) . "</td>
                <td class='px-6 py-4 text-slate-400'>" . htmlspecialchars($row["category_name"]) . "</td>
                <td class='px-6 py-4 font-semibold " . ($row['item_condition'] == 'Repair' ? 'text-orange-500' : ($row['item_condition'] == 'Working' ? 'text-green-500' : 'text-red-500')) . "'>" . $row["item_condition"] . "</td>
                <td class='px-6 py-4'>
                    <a href='" . htmlspecialchars($repairUrl) . "' class='hover:bg-blue-500 mx-1 bg-blue-400 text-white px-2 py-1 rounded'>Repair</a>
                    <a href='" . htmlspecialchars($transferUrl) . "' class='hover:bg-orange-500 mx-1 bg-orange-400 text-white px-2 py-1 rounded'>Transfer</a>
                    <a href='" . htmlspecialchars($condemnUrl) . "' class='hover:bg-red-500 mx-1 bg-red-400 text-white px-2 py-1 rounded'>Condemn</a>
                </td>
              </tr>";
    }
} else {
    echo "<tr class='bg-white border-b'><td colspan='5' class='py-3 text-center text-slate-400'>No data</td></tr>";
}
// free the memory
mysqli_free_result($result);
mysqli_close($connection);
