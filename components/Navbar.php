<?php
$currentFiles = basename($_SERVER['PHP_SELF']);
$name = '';

switch ($currentFiles) {
    case "Item.php":
        $name = "Item Page";
        break;
    case "Employee.php":
        $name = "Employee Page";
        break;
    case "Position.php":
        $name = "Position Page";
        break;
    case "Category.php":
        $name = "Category Page";
        break;
    case "Office.php":
        $name = "Office Page";
        break;
    case "ItemOwned.php":
        $name = "Item's Owned";
        break;
    case "Request.php":
        $name = "Request";
        break;
    case "Profile.php":
        $name = "Profile";
        break;
    case "Reset_Profile_Password.php":
        $name = "Reset Password";
        break;
    case "EmployeeRequest.php":
        $name = "Item Request";
        break;
    case "Archive.php":
        $name = "Archive";
        break;
    default:
        $name = "Page 404";
}

echo "<nav class='px-2 bg-white h-14 w-full border-b border-b-slate-200 z-10'>
<div class='flex px-2 items-center justify-between w-full h-full'>
    <div class='flex items-center gap-5'>
        <i id='open' class='fa-solid fa-bars cursor-pointer hover:text-blue-500 block sm:block md:block lg:block xl:block 2xl:hidden'></i>
        <h3 class='font-medium'>$name</h3>
    </div>
    <div class='flex items-center gap-2 cursor-pointer relative'>
        <img id='profile' class='w-8 h-8 rounded-full' src='https://api.dicebear.com/8.x/initials/svg?seed=" . $_SESSION["employee_name"] . "' alt='logo'/>
        <div id='tab' class='bg-white absolute top-14 whitespace-nowrap right-2 shadow-lg rounded w-54 h-auto py-2 px-4 z-10 hidden'>
            <header class='text-center border-b border-b-slate-200 py-2'>
                <h3>" . $_SESSION['employee_name'] . "</h3>
                <small class='text-slate-400'>" . $_SESSION['employee_roles'] . "</small>
            </header>
            <a class='flex items-center gap-2 text-slate-700 text-sm py-2 px-4 my-1 hover:bg-slate-100 rounded' href='../pages/Profile.php'><i class='fa-solid fa-user'></i> Profile</a>
            <a class='flex items-center gap-2 text-slate-700 text-sm py-2 px-4 my-1 hover:bg-slate-100 rounded' href='../pages/Reset_Profile_Password.php'><i class='fa-solid fa-key'></i> Reset Password</a>
            <a class='flex items-center gap-2 text-slate-700 text-sm py-2 px-4 my-1 hover:bg-slate-100 rounded' href='../api/logout.php?logout' href='../api/logout.php?logout'><i class='fa-solid fa-arrow-right-from-bracket'></i>Logout</a>
        </div>
    </div>
</div>
</nav>";

echo "<script>
    const profile = document.querySelector('#profile');
    const tab = document.querySelector('#tab');

    profile.addEventListener('click', function() {
       if(tab.classList.contains('hidden')){
            tab.classList.add('block');
            tab.classList.remove('hidden');
       }else{
            tab.classList.remove('block');
            tab.classList.add('hidden');
       }
    });
</script>";
