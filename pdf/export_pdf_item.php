<?php
require_once("../database/connection.php");
require_once("../utils/functions.php");
$html = "";
$result = null;
$sortArray = array("All", "Working", "Condemed");

if (isset($_GET["sort"])) {
    try {
        $sort = validateData($_GET["sort"]);
        if (!in_array($sort, $sortArray)) {
            throw new Exception("Invalid sort parameter");
        }

        $query = "SELECT
                    tbl_item.item_name,
                    tbl_item.item_condition,
                    tbl_employee.employee_first_name,
                    tbl_employee.employee_last_name,
                    tbl_office.office_name,
                    tbl_category.category_name 
                  FROM
                    tbl_item
                    INNER JOIN tbl_employee ON tbl_item.employee_id = tbl_employee.employee_id
                    INNER JOIN tbl_category ON tbl_item.category_id = tbl_category.category_id
                    INNER JOIN tbl_office ON tbl_employee.office_id = tbl_office.office_id 
                  WHERE tbl_employee.roles_id = 2";

        if ($sort !== "All") {
            $query .= " AND tbl_item.item_condition = ?";
        }
        $stmt = mysqli_prepare($connection, $query);

        if ($sort !== "All") {
            mysqli_stmt_bind_param($stmt, 's', $sort);
        }
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
    } catch (Exception $error) {
        header("Location: ../pdf/export_pdf_item.php?error=" . $error->getMessage());
        exit();
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <style>
        header {
            text-align: center;
        }

        main {
            width: 100%;
            height: 100vh;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        footer {
            width: 100%;
            padding: 20px 0px;
            text-align: center;
        }
        .signature{
            height: 200px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: end;
        }
        .signature-box{
            position: relative;
            width: 200px;
            text-align: center;
            font-size: 16px;
        }
        .signature-box img{
            position: absolute;
            left: 30px;
            top: 0px;
            width: 150px;
        }
        .box {
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <header>
        <h1>School Name Item Report</h1>
        <i><?php echo date('M d, Y'); ?></i>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item Name</th>
                    <th>Owner</th>
                    <th>Office</th>
                    <th>Category</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $num = 0;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $html .= "<tr class='bg-white border-b'>
                                        <td>" . ++$num . "</td>
                                        <td class='px-6 py-4 text-slate-400'>" . $row["item_name"] . "</td>
                                        <td class='px-6 py-4 font-medium text-slate-600 whitespace-nowrap'>
                                            " . $row["employee_last_name"] . ", " . $row["employee_first_name"] . "
                                        </td>
                                        <td class='px-6 py-4 text-slate-400'>" . $row["office_name"] . "</td>
                                        <td class='px-6 py-4 text-slate-400'>" . $row["category_name"] . "</td>
                                        <td class='px-6 py-4 text-slate-400'>" . $row["item_condition"] . "</td>
                                      </tr>";
                        }
                    } else {
                        $html .= "<tr class='bg-white border-b'><td colspan='5' class='py-3 text-center text-slate-400'>No data</td></tr>";
                    }
                    mysqli_free_result($result);
                } else {
                    $html .= "<tr><td colspan='6'>Error: " . mysqli_error($connection) . "</td></tr>";
                }

                echo $html;
                mysqli_close($connection);
                ?>
            </tbody>

        </table>
        <div class="signature">
            <div class="signature-box">
                <img src="https://2015.chrcreport.ca/sites/chrc-annual-report/files/message-signature.png" alt="signature">
                <p>John Doe</p>
                <div class="box">
                    <p>Name and Signature</p>
                </div>
            </div>
        </div>
    </main>
    <script type='text/javascript'>
        print();
    </script>
</body>

</html>