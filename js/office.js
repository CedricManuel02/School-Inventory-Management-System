const cancelModal = document.querySelector("#cancelModal");
const openModal = document.querySelector("#openModal");
const modalProduct = document.querySelector("#modal-product");
const modalEditProduct = document.querySelector("#modal-edit-product");
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
    modalEditProduct.classList.remove("fixed");
    modalEditProduct.classList.add("hidden");
});

function deleteOffice(office_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This will delete permanently",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
           window.location.href = "../api/delete_office.php?office_id=" + office_id;
        }
    });
}


function editOffice(office_id) {
    $.ajax({
        url: "../api/get_office_data.php",
        type: "POST",
        dataType: "json",
        data: { office_id: office_id},
        success: function (data) {
            $("#office_edit_id").val(data.office_id);
            $("#office_edit_name").val(data.office_name);
            modalEditProduct.classList.remove("hidden");
            modalEditProduct.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}
