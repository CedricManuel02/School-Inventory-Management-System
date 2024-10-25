const open = document.querySelector("#open");
const close = document.querySelector("#close");

open.addEventListener("click", () => {
    sidebar.classList.add("sidebar");
    sidebar.classList.remove("left-[-100%]");
    sidebar.classList.remove("close");
});

close.addEventListener("click", () => {
    sidebar.classList.remove("sidebar");
    sidebar.classList.add("close");
});

function requestButton(request_id, item_id, item_conditon) {
    Swal.fire({
        title: "Want to accept the request?",
        text: "",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, accept it!"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '../api/accept_request.php?request_id=' + request_id + "&item_id=" + item_id + "&item_condition=" + item_conditon;
        }
    });
}


