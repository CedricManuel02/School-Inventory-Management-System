// modal item 
const openModal = document.querySelector("#openModal");

const modalItemView = document.querySelector("#modalItemView");
const cancelViewModal = document.querySelector("#cancelViewModal");

const modalItemAdd = document.querySelector("#modalItemAdd");
const modalItemCancel = document.querySelector("#modalItemCancel");

const modelItemEdit = document.querySelector("#modalItemEdit");
const modalEditCancel = document.querySelector("#modalEditCancel");

const open = document.querySelector("#open");
const close = document.querySelector("#close");
const sidebar = document.querySelector("#sidebar");
const buttonPDF = document.querySelector("#generatePDF");

const sort = document.querySelector("#sort");
const equipment = document.getElementById('equipment');
const equipmentEdit = document.getElementById('equipment_edit');
const equipmentView = document.getElementById('equipment_view');
const itemBrandInput = document.getElementById('item_brand');
const itemSerialNoInput = document.getElementById('item_serial_no');
const itemModelNoInput = document.getElementById('item_model_no');

function toggleRequired(element, required) {
    if (required) {
        element.setAttribute('required', '');
    } else {
        element.removeAttribute('required');
    }
}
toggleRequired(itemBrandInput, true);
toggleRequired(itemSerialNoInput, true);
toggleRequired(itemModelNoInput, true);

document.getElementById('category_id').addEventListener('change', function() {
    const selectedOption = this.selectedOptions[0].textContent;
    if (selectedOption !== 'Furniture and Fixture') {
        equipment.classList.remove('hidden');
        toggleRequired(itemBrandInput, true);
        toggleRequired(itemSerialNoInput, true);
        toggleRequired(itemModelNoInput, true);
    } else {
        equipment.classList.add('hidden');
        toggleRequired(itemBrandInput, false);
        toggleRequired(itemSerialNoInput, false);
        toggleRequired(itemModelNoInput, false);
    }
});

document.getElementById('category_edit_id').addEventListener('change', function() {
    const selectedOption = this.selectedOptions[0].textContent;
    if (selectedOption !== 'Furniture and Fixture') {
        equipmentEdit.classList.remove('hidden');
        toggleRequired(itemBrandInput, true);
        toggleRequired(itemSerialNoInput, true);
        toggleRequired(itemModelNoInput, true);
    } else {
        equipmentEdit.classList.add('hidden');
        toggleRequired(itemBrandInput, false);
        toggleRequired(itemSerialNoInput, false);
        toggleRequired(itemModelNoInput, false);
    }
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
// open the modal
openModal.addEventListener("click", () => {
    modalItemAdd.classList.remove("hidden");
    modalItemAdd.classList.add("fixed");
});
// cancel the modal
modalViewCancel.addEventListener("click", () => {
    modalItemView.classList.remove("fixed");
    modalItemView.classList.add("hidden");

});
modalItemCancel.addEventListener("click", () => {
    modalItemAdd.classList.add("hidden");
    modalItemAdd.classList.remove("fixed");
})
modalEditCancel.addEventListener("click", () => {
    modelItemEdit.classList.remove("fixed");
    modelItemEdit.classList.add("hidden");

});
function deleteItem(itemId) {
    Swal.fire({
        title: "Are you sure you want to delete this?",
        text: "All data will be deleted, including the request of the item",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../api/delete_item.php?item_id=' + itemId;
        }
    });
}

function viewItem(item_id) {
    $.ajax({
        url: "../api/get_item_data.php",
        type: "POST",
        dataType: "json",
        data: { item_id: item_id},
        success: function (data) {
            $("#item_view_name").val(data.item_name);
            $("#item_view_amount").val(data.item_amount);
            $("#item_view_brand").val(data.item_brand);
            $("#item_view_serial_no").val(data.item_serial_no);
            $("#item_view_model_no").val(data.item_model_no);
            const date = new Date(data.item_date_purchased);
            const formattedDate = date.toISOString().split('T')[0]; 
            $("#item_view_date_purchased").val(formattedDate);

            $("#employee_view_id option").each(function() {
                if ($(this).text() === `${data.employee_first_name}, ${data.employee_last_name}`) {
                    $(this).prop('selected', true);
                }
            });
            $("#category_view_id option").each(function() {
                if ($(this).text() === data.category_name) {
                    $(this).prop('selected', true);
                }
            });
            if (data.category_name !== 'Furniture and Fixture') {
                equipmentView.classList.remove('hidden');
               
            } else {
                equipmentView.classList.add('hidden');
              
            }
            modalItemView.classList.remove("hidden");
            modalItemView.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}

function editItem(item_id) {
    $.ajax({
        url: "../api/get_item_data.php",
        type: "POST",
        dataType: "json",
        data: { item_id: item_id},
        success: function (data) {
            $("#item_edit_id").val(data.item_id);
            $("#item_edit_name").val(data.item_name);
            $("#item_edit_amount").val(data.item_amount);
            $("#item_edit_brand").val(data.item_brand);
            $("#item_edit_serial_no").val(data.item_serial_no);
            $("#item_edit_model_no").val(data.item_model_no);
            const date = new Date(data.item_date_purchased);
            const formattedDate = date.toISOString().split('T')[0]; 
            $("#item_edit_date_purchased").val(formattedDate);

            $("#employee_edit_id option").each(function() {
                if ($(this).text() === `${data.employee_first_name}, ${data.employee_last_name}`) {
                    $(this).prop('selected', true);
                }
            });
            $("#category_edit_id option").each(function() {
                if ($(this).text() === data.category_name) {
                    $(this).prop('selected', true);
                }
            });
            if (data.category_name !== 'Furniture and Fixture') {
                equipmentEdit.classList.remove('hidden');
               
            } else {
                equipmentEdit.classList.add('hidden');
            }
            modelItemEdit.classList.remove("hidden");
            modelItemEdit.classList.add("fixed");
        },
        error: function (){
            alert("Error: fill_update_modal L172+");
        }
    });
}
buttonPDF.addEventListener("click", () => {
    window.open('../pdf/export_pdf_item.php?sort=' + sort.value, 'name', 'width=1500,height=700');
})
