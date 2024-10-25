<?php
session_start();
if (!isset($_SESSION["employee_name"]) || !isset($_SESSION["employee_email"])) {
    header("Location: ../pages/Login.php");
    exit();
} else if ($_SESSION["employee_roles"] === "User") {
    header("Location: ../pages/ItemOwned.php");
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Item | Inventory System</title>
</head>
<body>
    <div class="flex min-h-screen w-full h-auto shadow">
        <!--Modal Components-->
        <div class="hidden z-30 w-full h-screen" id="modalItemAdd">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class=" h-auto bg-white rounded-md px-5 py-2 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                        <form method="POST" action="../api/set_item.php" enctype="multipart/form-data" class="h-full flex flex-col justify-between">
                            <header class="py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="font-medium">Add Item</h2>
                                    <small class="text-sm text-slate-400">Create a item information</small>
                                </div>
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="modalItemCancel"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_id" class="text-sm text-slate-600 font-medium">Employee Name</label>
                                        <select name="employee_id" id="employee_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_employee_dropdown.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex w-96 flex-col gap-2">
                                        <label for="category_id" class="text-sm text-slate-600 font-medium">Category</label>
                                        <select name="category_id" id="category_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <?php
                                            include "../api/get_category.php";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_name" class="text-sm text-slate-600 font-medium">Item Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_name" name="item_name" type="text" placeholder="Enter name" required>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_amount" class="text-sm text-slate-600 font-medium">Item Amount</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_amount" name="item_amount" type="number" min="0" placeholder="Enter amount" required>
                                    </div>
                                </div>
                                <div id="equipment" class="block py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_brand" class="text-sm text-slate-600 font-medium">Brand</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_brand" name="item_brand" type="text" placeholder="Enter brand">
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_serial_no" class="text-sm text-slate-600 font-medium">Serial No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_serial_no" name="item_serial_no" type="text" placeholder="Enter serial number">
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_model_no" class="text-sm text-slate-600 font-medium">Model No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_model_no" name="item_model_no" type="text" placeholder="Enter model number">
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_date_purchased" class="text-sm text-slate-600 font-medium">Date Purchased</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_date_purchased" name="item_date_purchased" type="date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end py-5">
                                <button type="submit" class="py-2 px-5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
           <!--View Components-->
        <div class="hidden z-30 w-full h-screen" id="modalItemView">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class=" h-auto bg-white rounded-md px-5 py-10 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                            <header class="flex justify-between">
                                <div>
                                    <h2 class="font-medium">Item Details</h2>
                                    <small class="text-sm text-slate-400">Item's information</small>
                                </div>
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="modalViewCancel"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_view_id" class="text-sm text-slate-600 font-medium">Employee Name</label>
                                        <select name="employee_view_id" id="employee_view_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" disabled>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_employee_dropdown.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex w-96 flex-col gap-2">
                                        <label for="category_view_id" class="text-sm text-slate-600 font-medium">Category</label>
                                        <select name="category_view_id" id="category_view_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" disabled>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_category.php";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_name" class="text-sm text-slate-600 font-medium">Item Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_name" name="item_view_name" type="text" disabled>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_amount" class="text-sm text-slate-600 font-medium">Item Amount</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_amount" name="item_view_amount" type="number" disabled>
                                    </div>
                                </div>
                                <div id="equipment_view" class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_brand" class="text-sm text-slate-600 font-medium">Brand</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_brand" name="item_view_brand" type="text" disabled>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_serial_no" class="text-sm text-slate-600 font-medium">Serial No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_serial_no" name="item_view_serial_no" type="text" disabled>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_model_no" class="text-sm text-slate-600 font-medium">Model No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_model_no" name="item_view_model_no" type="text" disabled>
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_view_date_purchased" class="text-sm text-slate-600 font-medium">Date Purchased</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_view_date_purchased" name="item_view_date_purchased" type="date" disabled>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
          <!--Edit Components-->
          <div class="hidden z-30 w-full h-screen" id="modalItemEdit">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class=" h-auto bg-white rounded-md px-5 py-2 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                        <form method="POST" action="../api/update_item.php" enctype="multipart/form-data" class="h-full flex flex-col justify-between">
                            <header class="py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="font-medium">Edit Item</h2>
                                    <small class="text-sm text-slate-400">Update item information</small>
                                </div>
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="modalEditCancel"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <input type="hidden" id="item_edit_id" name="item_id" required>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_edit_id" class="text-sm text-slate-600 font-medium">Employee Name</label>
                                        <select name="employee_edit_id" id="employee_edit_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_employee_dropdown.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex w-96 flex-col gap-2">
                                        <label for="category_edit_id" class="text-sm text-slate-600 font-medium">Category</label>
                                        <select name="category_edit_id" id="category_edit_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <?php
                                            include "../api/get_category.php";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_name" class="text-sm text-slate-600 font-medium">Item Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_name" name="item_edit_name" type="text" placeholder="Enter name" required>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_amount" class="text-sm text-slate-600 font-medium">Item Amount</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_amount" name="item_edit_amount" type="number" min="0" placeholder="Enter amount" required>
                                    </div>
                                </div>
                                <div id="equipment_edit" class="block py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_brand" class="text-sm text-slate-600 font-medium">Brand</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_brand" name="item_edit_brand" type="text" placeholder="Enter brand">
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_serial_no" class="text-sm text-slate-600 font-medium">Serial No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_serial_no" name="item_edit_serial_no" type="text" placeholder="Enter serial number">
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_model_no" class="text-sm text-slate-600 font-medium">Model No</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_model_no" name="item_edit_model_no" type="text" placeholder="Enter model number">
                                    </div>
                                </div>
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="item_edit_date_purchased" class="text-sm text-slate-600 font-medium">Date Purchased</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="item_edit_date_purchased" name="item_edit_date_purchased" type="date" required>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end py-5">
                                <button type="submit" class="py-2 px-5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--Main Components-->
        <?php
        include "../components/Sidebar.php";
        ?>
        <section class="w-full h-auto">
            <?php
            include "../components/Navbar.php";
            ?>
            <div class="px-4 py-10 w-full">
                    <div class="flex items-center justify-between py-5">
                        <div class="flex flex-wrap items-center justify-end gap-2">
                            <button type="button" id="openModal" class="py-2 px-5 bg-blue-600 text-white font-normal rounded-md hover:bg-blue-500 shadow-sm">Add Item</button>
                            <button type="button" id="generatePDF" class="py-2 px-5 bg-green-600 text-white font-normal rounded-md hover:bg-green-500 flex items-center justify-around gap-2 shadow-sm">Print <i class="fa-solid fa-print"></i></button>
                            <select id="sort" class="py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                             <option value="All" selected disabled>Select</option>
                             <option value="All">All</option>
                             <option value="Working">Working</option>
                             <option value="Condemed">Condemed</option>
                            </select>
                        </div>
                        
                    </div>
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
                <div class="relative overflow-x-auto rounded-md overflow-none shadow-sm">
                    <table class="px-2 w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Item Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Owner
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Position
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Category
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Condition
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date Created
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                       <?php
                           include "../api/table_item.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/item.js"></script>
</body>
</html>