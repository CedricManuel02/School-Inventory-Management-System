<?php
session_start();
$router = "";
if (isset($_SESSION["employee_name"]) && isset($_SESSION["employee_roles"])) {
    $router = ($_SESSION["employee_roles"] === "Admin") ? "../pages/Item.php" : "../pages/Request.php";
    header("Location: $router");
    exit();
}
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Login | Inventory System</title>
</head>

<body>
    <div class="flex h-screen w-full flex items-center justify-center bg-slate-200">
        <div class="w-11/12 h-4/6 flex justify-between bg-white rounded-md shadow-lg overflow-hidden sm:w-11/12 md:w-10/12 lg:w-8/12 xl:w-6/12 2xl:w-6/12">
            <div class="w-full h-full relative before:absolute before:content-[''] before:w-full before:h-full before:bg-[rgba(0,0,0,0.4)] hidden sm:hidden md:block lg:block xl:block 2xl:block">
                <img class="w-full h-full object-cover" src="https://upd.edu.ph/wp-content/uploads/2014/09/UPIS2.jpg" alt="image">
            </div>
            <div class="w-[800px] px-4 flex flex-col justify-center m-auto gap-2 sm:px-4 md:px-8 lg:px-8 xl:px-8 2xl:px-8">
            <header class="text-center">
                <h2 class="font-medium text-2xl text-slate-800 py-2">Login</h2>
                <h3 class="text-md text-slate-500">Name of School National High School</h3>
            </header>
            <?php
            if (isset($_GET["error"])) {
                echo "<div class='w-full bg-red-200 p-4 rounded'>
                                        <p class='text-sm text-red-600 font-medium'>" . $_GET["error"] . "</p>
                                    </div>";
            }
            if (isset($_GET["success"])) {
                echo "<div class='w-full bg-green-200 p-4 rounded'>
                                        <p class='text-sm text-green-600 font-medium'>" . $_GET["success"] . "</p>
                                    </div>";
            }
            ?>
            <form method="POST" action="../api/login.php">
                <div class="flex flex-col gap-2 py-2">
                    <label class="text-sm font-base text-slate-800" for="email">Email</label>
                    <input class="w-full p-3 border rounded text-sm" type="text" id="email" name="email" placeholder="Enter your email" value="<?php if(isset($_COOKIE["email"])){echo $_COOKIE["email"];}?>" autocomplete="off" required>
                </div>
                <div class="flex flex-col gap-2 py-2">
                    <label class="text-sm font-base text-slate-800" for="password">Password</label>
                    <input class="w-full p-3 border rounded text-sm" type="password" id="password" name="password" placeholder="Enter your password"  autocomplete="off" required>
                </div>
                <div class="flex items-center justify-between py-2">
                <div class="flex items-center gap-2">
                    <label class="cursor-pointer" for="remember_me">
                        Remember Me?
                    </label>
                    <input class="cursor-pointer" type="checkbox" name="remember_me" id="remember_me" <?php if(isset($_COOKIE["remember_me"])){echo "checked";}?>>
                </div>
                <a class="underline text-blue-500" href="../pages/Forgot_Password.php">Forgot Password?</a>
                </div>
                <div class="py-5">
                    <button type="submit" class="w-full py-2 rounded bg-blue-600 text-white font-medium hover:bg-blue-400">Login</button>
                </div>
            </form>
        </div>
        </div>
    </div>
   
</body>

</html>