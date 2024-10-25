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
    <title>Position | Inventory System</title>
</head>

<body>
    <div class="flex min-h-screen h-auto shadow">
        <!--Modal Components-->
        <div class="hidden z-30 w-full h-screen" id="modal-position">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class="h-auto bg-white rounded-md px-5 py-2 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-3/12">
                        <form method="POST" action="../api/set_position.php" class="h-full flex flex-col justify-between">
                            <header class="py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="font-medium">Add Position</h2>
                                </div> 
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="cancelModal"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="position_name" class="text-sm">Position Name</label>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="position_name" name="position_name" type="text" placeholder="Enter position" required>
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
         <!--Edit Modal Components-->
         <div class="hidden z-30 w-full h-screen" id="modal-edit-position">
            <div class="w-full h-screen absolute" style="background-color: rgb(0,0,0,0.8);">
                <div class="h-full w-full flex items-center justify-center">
                    <div class="h-auto bg-white rounded-md px-5 py-2 w-11/12 sm:w-10/12 md:w-7/12 lg:w-5/12 2xl:w-3/12">
                        <form method="POST" action="../api/update_position.php" class="h-full flex flex-col justify-between">
                            <header class="py-5 flex items-center justify-between">
                                <div>
                                    <h2 class="font-medium">Edit Position</h2>
                                </div> 
                                <i class="fa fa-close cursor-pointer hover:text-blue-500" id="cancelEditModal"></i>
                            </header>
                            <div class="h-full w-full">
                                <div class="py-2 flex items-center gap-2 justify-between">
                                    <div class="flex flex-col gap-2 w-full">
                                        <label for="position_edit_name" class="text-sm">Position Name</label>
                                        <input class="hidden" id="position_edit_id" name="position_edit_id" type="number" required>
                                        <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="position_edit_name" name="position_edit_name" type="text" placeholder="Enter position" required>
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
            <div class="px-5 py-10">
                <div class="py-5">
                     <button type="button" id="openModal" class="py-2 px-5 bg-blue-600 text-white font-normal rounded-md hover:bg-blue-500">Add Position</button>
                </div>
                <?php
                    if(isset($_GET["error"])){
                        echo "<div class='bg-red-200 p-4 rounded my-2 text-sm flex gap-2'>
                                <p  class='text-red-700 font-base'>".$_GET["error"]."</p>
                            </div>";
                    }
                    if(isset($_GET["success"])){
                        echo "<div class='bg-green-200 p-4 rounded my-2 text-sm flex gap-2'>
                                <p  class='text-green-700 font-base'>".$_GET["success"]."</p>
                            </div>";
                    }
                ?>
                <div class="relative overflow-x-auto rounded-md overflow-none shadow-sm">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-700 uppercase bg-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Position Name
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
                            include "../api/table_position.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="../js/position.js"></script>
</body>
</html>