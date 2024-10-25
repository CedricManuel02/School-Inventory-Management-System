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




