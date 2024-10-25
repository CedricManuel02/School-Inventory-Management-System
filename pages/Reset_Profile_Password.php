<?php
session_start();
if (!isset($_SESSION["employee_name"]) && !isset($_SESSION["employee_email"])) {
    header("Location: ../pages/Login.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Reset Password | Inventory System</title>
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
                    <header class="flex items-center justify-between">
                        <div>
                            <h2 class="font-medium">Reset Password</h2>
                            <small class="text-sm text-slate-400">Change your password.</small>
                        </div>
                    </header>
                    <?php
                    if (isset($_GET["error"])) {
                        echo "<div class='w-full bg-red-200 p-4 rounded my-4'>
                                    <p class='text-sm text-red-600 font-medium'>" . $_GET["error"] . "</p>
                                </div>";
                    }
                    if (isset($_GET["success"])) {
                        echo "<div class='w-full bg-green-200 p-4 rounded my-4'>
                                <p class='text-sm text-green-600 font-medium'>" . $_GET["success"] . "</p>
                            </div>";
                    }
                    ?>
                    <form method="POST" action="../api/change_password.php">
                        <div class="py-2 flex flex-col items-center gap-2 justify-between">
                            <div class="flex flex-col gap-2 w-full">
                                <label for="new_password" class="text-sm">New Password</label>
                                <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="new_password" name="new_password" type="password" placeholder="New password" >
                            </div>
                        </div>
                        <div class="py-2 flex items-center gap-2 justify-between">
                            <div class="flex flex-col gap-2 w-full">
                                <label for="confirm_password" class="text-sm">Confirm Password</label>
                                <input class="w-full py-2 px-3 border rounded appearance-none focus:outline-blue-300" id="confirm_password" name="confirm_password" type="password" placeholder="Confirm your password" >
                            </div>
                        </div>
                        <div class="flex items-center justify-end py-5">
                            <button type="submit" class="py-2 px-5 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-500">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>