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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Employee | Inventory System</title>
</head>

<body>
    <div class="flex min-h-screen h-auto shadow">
        <!--Modal Components-->
        <div class="hidden z-30 w-full h-screen" id="modalAddEmployee">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class="h-auto py-8 bg-white rounded-md px-5 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                        <form method="POST" action="../api/set_employee.php" class="h-full flex flex-col justify-between">
                            <header class="flex justify-between">
                                <div>
                                    <h2 class="font-medium">Add Employee</h2>
                                    <small class="text-sm text-slate-400">Create a Employee information</small>
                                </div>
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="cancelModal"></i>
                            </header>
                            <div class="bg-blue-200 text-blue-800 p-4 rounded-md gap-2 text-sm">
                            <p><b>Note:</b> Default username is the username. The password is the username and password</p>
                            </div>
                            <div class="h-full w-full">
                                <div class="py-2 flex flex-col items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_first_name" class="text-sm">First Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_first_name" name="employee_first_name" type="text" placeholder="Enter first name" required>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_last_name" class="text-sm">Last Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_last_name" name="employee_last_name" type="text" placeholder="Enter last name" required>
                                    </div>
                                </div>
                                <div class="py-2 flex flex-col items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_email" class="text-sm">Email</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_email" name="employee_email" type="email" placeholder="Enter email address" required>
                                    </div>
                                </div>
                                <div class="py-2 flex  items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="position_id" class="text-sm">Position</label>
                                        <select name="position_id" id="position_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_position.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="office_id" class="text-sm">Office</label>
                                        <select name="office_id" id="office_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_office.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="office_id" class="text-sm">Roles</label>
                                        <select name="roles_id" id="roles_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_roles.php";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end py-2">
                                <button type="submit" class="py-2 px-5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ViewModal Components-->
        <div class="hidden z-30 w-full h-screen" id="modalViewEmployee">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class="h-auto py-8 bg-white rounded-md px-5 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                        <header class="flex items-center justify-between">
                            <div>
                                <h2 class="font-medium">Employee's Details</h2>
                                <small class="text-sm text-slate-400">View Employee's information</small>
                            </div>
                            <i class="fa fa-close cursor-pointer hover:text-blue-500" id="cancelViewModal"></i>
                        </header>
                        <div class="h-full w-full">
                            <div class="py-2 flex flex-col items-center gap-2 justify-between">
                                <div class="flex flex-col gap-2 w-full">
                                    <label for="employee_view_first_name" class="text-sm">First Name</label>
                                    <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300 text-slate-500" id="employee_view_first_name" name="employee_view_first_name" type="text" disabled>
                                </div>
                                <div class="flex flex-col gap-2 w-full">
                                    <label for="employee_view_last_name" class="text-sm">Last Name</label>
                                    <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300 text-slate-500" id="employee_view_last_name" name="employee_view_last_name" type="text" disabled>
                                </div>
                            </div>
                            <div class="py-2 flex  items-center gap-2 justify-between">
                                <div class="flex flex-col gap-2 w-full">
                                    <label for="position_view_id" class="text-sm">Position</label>
                                    <select name="position_view_name" id="position_view_name" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" disabled>
                                        <option value="" selected disabled>Select</option>
                                        <?php
                                        include "../api/get_position.php";
                                        ?>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2 w-full">
                                    <label for="office_view_id" class="text-sm">Office</label>
                                    <select name="office_view_name" id="office_view_name" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" disabled>
                                        <option value="" selected disabled>Select</option>
                                        <?php
                                        include "../api/get_office.php";
                                        ?>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-2 w-full">
                                    <label for="roles_view_name" class="text-sm">Roles</label>
                                    <select name="roles_view_name" id="roles_view_name" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" disabled>
                                        <option value="" selected disabled>Select</option>
                                        <?php
                                        include "../api/get_roles.php";
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Edit Modal Components-->
        <div class="hidden z-30 w-full h-screen" id="modalEditEmployee">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class="h-auto py-8 bg-white rounded-md px-5 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-4/12">
                        <form method="POST" action="../api/update_employee.php" class="h-full flex flex-col justify-between">
                            <header class="flex items-center justify-between">
                                <div>
                                    <h2 class="font-medium">Edit Employee</h2>
                                    <small class="text-sm text-slate-400">Update Employee information</small>
                                </div>
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="cancelEditModal"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex flex-col items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_edit_first_name" class="text-sm">First Name</label>
                                        <input class="hidden" id="employee_edit_id" name="employee_edit_id" type="number" required>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_edit_first_name" name="employee_edit_first_name" type="text" placeholder="Enter first name" required>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="employee_edit_last_name" class="text-sm">Last Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_edit_last_name" name="employee_edit_last_name" type="text" placeholder="Enter last name" required>
                                    </div>
                                </div>
                                <div class="py-2 flex  items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="position_edit_id" class="text-sm">Position</label>
                                        <select name="position_edit_id" id="position_edit_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_position.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="office_edit_id" class="text-sm">Office</label>
                                        <select name="office_edit_id" id="office_edit_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_office.php";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="roles_edit_id" class="text-sm">Roles</label>
                                        <select name="roles_edit_id" id="roles_edit_id" class="w-full py-2 px-3 border rounded cursor-pointer focus:outline-blue-300" required>
                                            <option value="" selected disabled>Select</option>
                                            <?php
                                            include "../api/get_roles.php";
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end py-2">
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
            <div class="px-5 py-10">
                <div class="flex my-5 flex-wrap gap-2 items-center justify-between">
                    <button type="button" id="openModal" class="py-2 px-5 bg-blue-600 text-white font-normal rounded-md hover:bg-blue-500 w-full sm:w-44 md:w-44 lg:w-44 xl:w-44 2xl:w-44">Add Employee</button>
                    <input id="search" class="w-full sm:w-64 md:w-64 lg:w-64 xl:w-64 2xl:w-64 py-2 px-3 border rounded focus:outline-blue-300" type="text" placeholder="Search employee...">
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
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Position
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Office
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
                            include "../api/table_employee.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/employee.js"></script>
</body>

</html>