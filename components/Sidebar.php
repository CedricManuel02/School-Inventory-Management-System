
<?php
$currentFile = basename($_SERVER['PHP_SELF']);
echo "
<div>
    <div id='sidebar' class='w-64 z-20 h-full left-[-100%] absolute sm:absolute sm:z-20 md:absolute md:z-20 lg:absolute lg:z-20 2xl:left-0 2xl:relative  ' >
        <aside class='w-64 h-full py-5 px-2 flex flex-col justify-between border-r border-r-slate-200 bg-[#050505]  fixed'>
            <header class='relative py-5 px-2 flex items-center justify-start gap-2'>
                <i id='close' class='fa-solid fa-xmark absolute right-2 top-[-4px] text-slate-200 hover:text-blue-500 block sm:block md:block lg:block xl:block 2xl:hidden'></i>
                <img class='w-12 object-cover' src='../assets/LOGO.png' alt='profile' />
                <h2 class='font-medium text-lg uppercase text-white'>Name System</h2>
            </header>
            <ul class='h-full py-5'>";
        if ($_SESSION["employee_roles"] == "Admin") {
            echo " <li class='py-3 px-5 my-2 " . ($currentFile == 'Item.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Item.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-plus'></i>Item</a></li>
                <li class='py-3 px-5 my-2 " . ($currentFile == 'Employee.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Employee.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-users'></i>Employee</a></li>
                <li class='py-3 px-5 my-2 " . ($currentFile == 'Category.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Category.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-list'></i>Category</a></li>
                <li class='py-3 px-5 my-2 " . ($currentFile == 'Position.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Position.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-user-plus'></i>Position</a></li>
                <li class='py-3 px-5 my-2 " . ($currentFile == 'Office.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Office.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-id-card'></i>Office</a></li>
                <li class='py-3 px-5 my-2 " . ($currentFile == 'Request.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Request.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-comment-dots'></i>Request</a></li>";
        } else {
            echo "<li class='py-3 px-5 my-2 " . ($currentFile == 'ItemOwned.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./ItemOwned.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-folder'></i>Item's Owned</a></li>";
            echo "<li class='py-3 px-5 my-2 " . ($currentFile == 'EmployeeRequest.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./EmployeeRequest.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-folder'></i>Request</a></li>";
            echo "<li class='py-3 px-5 my-2 " . ($currentFile == 'Archive.php' ? 'bg-[#121212] rounded-md' : '') . "'><a href='./Archive.php' class='flex items-center gap-2 justify-start text-sm font-medium text-slate-400 hover:text-slate-600'><i class='w-5 fa-solid fa-folder'></i>Archive</a></li>";
        }
        echo "</ul>
            
        </aside>
    </div>
</div>";
?>

