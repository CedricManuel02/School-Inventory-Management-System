<?php
session_start();
if (!isset($_SESSION["employee_name"]) && !isset($_SESSION["employee_email"])) {
    header("Location: ../pages/Login.php");
    exit();
} elseif ($_SESSION["employee_roles"] === "Admin") {
    header("Location: ../pages/Item.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Item Owned | Inventory System</title>
</head>

<body>
    <div class="flex min-h-screen h-auto shadow">
        <!--Main Components-->
        <?php
        include "../components/Sidebar.php";
        ?>
        <section class="w-full h-auto">
            <?php
                include "../components/Navbar.php";
            ?>
            <div class="px-5 py-10">
                <?php
                if (isset($_GET["error"])) {
                    echo "<div class='bg-red-200 p-4 rounded my-2 text-sm flex gap-2'>
                                <p  class='text-red-700 font-base'>" . $_GET["error"] . "</p>
                            </div>";
                }
                if (isset($_GET["success"])) {
                    echo "<div class='bg-green-200 p-4 rounded my-2 text-sm flex gap-2'>
                                <p  class='text-green-700 font-base'>" . $_GET["success"] . "</p>
                            </div>";
                }
                ?>
                <div class="relative overflow-x-auto rounded-md overflow-none">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Item Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Brand
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Condition
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php
                                include "../api/table_employee_items.php";
                           ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/item_owned.js"></script>
</body>

</html>