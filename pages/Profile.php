<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION["employee_name"]) && !isset($_SESSION["employee_email"])) {
    header("Location: ../pages/Login.php");
}
?>
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Profile | Inventory System</title>
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
                <div class="m-auto w-full sm:w-11/12 md:w-11/12 lg:w-8/12 xl:w-5/12 2xl:w-5/12">
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
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="font-medium">Profile</h2>
                            <small class="text-sm text-slate-400">Manage your account information</small>
                        </div>
                    </header>
                    <form method="POST" action="../api/update_profile.php">
                        <div class="py-2 flex flex-col items-center gap-2 justify-between">
                            <div class="flex flex-col gap-2 w-full">
                                <label for="employee_first_name" class="text-sm">First Name</label>
                                <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_first_name" name="employee_first_name" value="<?php echo $_SESSION['employee_first_name'] ?>" type="text" placeholder="Enter first name" required>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <label for="employee_last_name" class="text-sm">Last Name</label>
                                <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="employee_last_name" name="employee_last_name" type="text" value="<?php echo $_SESSION['employee_last_name'] ?>" placeholder="Enter last name" required>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex flex-col gap-2 w-full">
                                <label for="position_name" class="text-sm">Position</label>
                                <input class="w-full py-2 px-3 border text-slate-500 rounded appearance-none focus:outline-blue-300" id="position_name" value="<?php echo $_SESSION['position_name'] ?>" type="text" disabled>
                            </div>
                            <div class="flex flex-col gap-2 w-full">
                                <label for="office_name" class="text-sm">Office</label>
                                <input class="w-full py-2 px-3 border text-slate-500 rounded appearance-none focus:outline-blue-300" id="office_name" value="<?php echo $_SESSION['office_name'] ?>" type="text" disabled>
                            </div>
                        </div>
                        <div class="flex items-center justify-end py-5">
                            <button type="submit" class="py-2 px-5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>