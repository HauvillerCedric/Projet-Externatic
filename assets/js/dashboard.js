const toggler = document.querySelector(".btn-dashboard");

if (toggler) {
    toggler.addEventListener("click", () => {
        document.querySelector("#sidebar").classList.toggle("collapsed");
    });
}
