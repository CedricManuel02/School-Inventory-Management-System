// modal product 
const cancelModal = document.querySelector("#cancelModal");
const openModal = document.querySelector("#openModal");
const modalProduct = document.querySelector("#modalAddEmployee");
const viewEmployeeModal = document.querySelector("#modalViewEmployee");
const editEmployeeModal = document.querySelector("#modalEditEmployee");
const closeViewModal = document.querySelector("#cancelViewModal");
const closeEditModal = document.querySelector("#cancelEditModal");
const open = document.querySelector("#open");
const close = document.querySelector("#close");
const sidebar = document.querySelector("#sidebar");

const search = document.querySelector("#search");

// search function 
search.addEventListener("keyup", (e) => {
    const values = e.target.value.toLowerCase(); // get the values from user and set them to lowercase
    const rows = document.querySelectorAll("tbody tr"); // select all table rows in tbody elements
    // loop through each row 
    rows.forEach((row) => {
        // get the id of each cell that has an id name
        const cell = row.querySelector("#name");
        /* check if the cell contains name id and set the cell 
        text content to lowercase if not leave it empty*/
        const name = cell ? cell.textContent.toLowerCase() : "";

        // check if the values user searched for includes
        if (name.includes(values)) {
            row.style.display = ""; 
        } else {
            row.style.display = "none";
        }
    });
});


// open the modal
openModal.addEventListener("click", () => {
    modalProduct.classList.remove("hidden");
    modalProduct.classList.add("fixed");
});
// cancel the modal
cancelModal.addEventListener("click", () => {
    modalProduct.classList.remove("fixed");
    modalProduct.classList.add("hidden");
   
});

open.addEventListener("click", () => {
    sidebar.classList.add("sidebar");
    sidebar.classList.remove("left-[-100%]");
    sidebar.classList.remove("close");
});

close.addEventListener("click", () => {
    sidebar.classList.remove("sidebar");
    sidebar.classList.add("close");
});

// cancel the modal
closeViewModal.addEventListener("click", () => {
    viewEmployeeModal.classList.remove("fixed");
    viewEmployeeModal.classList.add("hidden");
});
// cancel the modal
closeEditModal.addEventListener("click", () => {
    editEmployeeModal.classList.remove("fixed");
    editEmployeeModal.classList.add("hidden");
});
function deleteEmployee(employee_id) {
    Swal.fire({
        title: "Are you sure you want to delete this?",
        text: "All data will be deleted, including all the item and request made by this employee",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../api/delete_employee.php?employee_id=' + employee_id;
        }
    });
}

function viewEmployee(employee_id){
    $.ajax({
        url: "../api/get_employee_data.php",
        type: "POST",
        dataType: "json",
        data: { employee_id: employee_id},
        success: function (data) {
            console.log(data);
            $("#employee_view_id").val(data.employee_id);
            $("#employee_view_first_name").val(data.employee_first_name);
            $("#employee_view_last_name").val(data.employee_last_name);
            $("#employee_view_middle_name").val(data.employee_middle_name);
            $("#employee_view_contact_no").val(data.employee_contact_no);
            $("#employee_view_email").val(data.employee_email);

            $("#position_view_name option").each(function() {
                if ($(this).text() === data.position_name) {
                    $(this).prop('selected', true);
                }
            });

            $("#roles_view_name option").each(function() {
                if ($(this).text() === data.roles) {
                    $(this).prop('selected', true);
                }
            });
            
            $("#office_view_name option").each(function() {
                if ($(this).text() === data.office_name) {
                    $(this).prop('selected', true);
                }
            });
         
            viewEmployeeModal.classList.remove("hidden");
            viewEmployeeModal.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}
function editEmployee(employee_id) {
    $.ajax({
        url: "../api/get_employee_data.php",
        type: "POST",
        dataType: "json",
        data: { employee_id: employee_id},
        success: function (data) {
            console.log(data);
            $("#employee_edit_id").val(data.employee_id);
            $("#employee_edit_first_name").val(data.employee_first_name);
            $("#employee_edit_last_name").val(data.employee_last_name);
            $("#employee_edit_middle_name").val(data.employee_middle_name);
            $("#employee_edit_contact_no").val(data.employee_contact_no);
            $("#employee_edit_email").val(data.employee_email);
            $("#position_edit_id").val(data.position_id);
            $("#office_edit_id").val(data.office_id);
            $("#roles_edit_id").val(data.roles_id);

            $("#position_edit_id option").each(function() {
                if ($(this).text() === data.position_name) {
                    $(this).prop('selected', true);
                }
            });
            $("#roles_edit_id option").each(function() {
                if ($(this).text() === data.roles) {
                    $(this).prop('selected', true);
                }
            });
            
            $("#office_edit_id option").each(function() {
                if ($(this).text() === data.office_name) {
                    $(this).prop('selected', true);
                }
            });
         
            editEmployeeModal.classList.remove("hidden");
            editEmployeeModal.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}
