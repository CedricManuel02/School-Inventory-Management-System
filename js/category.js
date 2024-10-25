// modal product 
const cancelModal = document.querySelector("#cancelModal");
const openModal = document.querySelector("#openModal");
const modalProduct = document.querySelector("#modal-product");
const modalEditCategory = document.querySelector("#modal-edit-category");
const cancelEditModal = document.querySelector("#cancelEditModal");
const open = document.querySelector("#open");
const close = document.querySelector("#close");
const sidebar = document.querySelector("#sidebar");

open.addEventListener("click", () => {
    sidebar.classList.add("sidebar");
    sidebar.classList.remove("left-[-100%]");
    sidebar.classList.remove("close");
});

close.addEventListener("click", () => {
    sidebar.classList.remove("sidebar");
    sidebar.classList.add("close");
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
// cancel the modal
cancelEditModal.addEventListener("click", () => {
    modalEditCategory.classList.remove("fixed");
    modalEditCategory.classList.add("hidden");
});

function deleteCategory(category_id) {
    Swal.fire({
        title: "Are you sure you want to delete this?",
        text: "This will permanently delete the category",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../api/delete_category.php?category_id=' + category_id;
        }
    });
}
function editCategory(category_id) {
    $.ajax({
        url: "../api/get_category_data.php",
        type: "POST",
        dataType: "json",
        data: { category_id: category_id},
        success: function (data) {
            $("#category_edit_id").val(data.category_id);
            $("#category_edit_name").val(data.category_name);
            modalEditCategory.classList.remove("hidden");
            modalEditCategory.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}




