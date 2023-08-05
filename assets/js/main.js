document.addEventListener("DOMContentLoaded", function() {
    var toggle = document.querySelector(".toggle");
    var items = document.querySelectorAll(".item");
    
    toggle.addEventListener("click", function() {
        for (let i = 0; i < items.length; i++) {
            if (items[i].classList.contains("active")) {
                items[i].classList.remove("active");
            } else {
                items[i].classList.add("active");
            }
        }
    });
});

