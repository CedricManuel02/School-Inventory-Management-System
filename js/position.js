// modal product 
const cancelModal = document.querySelector("#cancelModal");
const openModal = document.querySelector("#openModal");
const modalProduct = document.querySelector("#modal-position");
const modalEditPosition = document.querySelector("#modal-edit-position");
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
    modalEditPosition.classList.remove("fixed");
    modalEditPosition.classList.add("hidden");
});
function deletePosition(position_id) {
    Swal.fire({
        title: "Are you sure you want to delete this?",
        text: "This will delete permanently",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../api/delete_position.php?position_id=' + position_id;
        }
    });
}

function editPosition(position_id) {
    $.ajax({
        url: "../api/get_position_data.php",
        type: "POST",
        dataType: "json",
        data: { position_id: position_id},
        success: function (data) {
            $("#position_edit_id").val(data.position_id);
            $("#position_edit_name").val(data.position_name);
            modalEditPosition.classList.remove("hidden");
            modalEditPosition.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}