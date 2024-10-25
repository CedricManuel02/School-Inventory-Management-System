const new_password = document.querySelector('#new_password');
const confirm_password = document.querySelector('#confirm_password');
const error_message = document.querySelector('#error_message');

confirm_password.addEventListener("keyup", (e) => {
    if (new_password.value === e.target.value) {
        error_message.classList.remove("hidden", "text-red-500");
        error_message.classList.add("block", "text-green-500");
        error_message.innerText = "Password match";
    } else if (e.target.value === "") {
        error_message.classList.remove("block", "text-red-500", "text-green-500");
        error_message.classList.add("hidden");
        error_message.innerText = "";
    } else {
        error_message.classList.remove("hidden", "text-green-500");
        error_message.classList.add("block", "text-red-500");
        error_message.innerText = "Password mismatch";
    }
});
