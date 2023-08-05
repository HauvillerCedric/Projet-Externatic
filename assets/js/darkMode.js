(function () {
    // Switch Btn
    var switchBox = document.createElement("div");
    switchBox.className = "switch-box";

    var label = document.createElement("label");
    label.id = "switch";
    label.className = "switch";

    var input = document.createElement("input");
    input.type = "checkbox";
    input.addEventListener("change", toggleTheme);
    input.id = "slider";

    var span = document.createElement("span");
    span.className = "slider round";

    label.appendChild(input);
    label.appendChild(span);

    switchBox.appendChild(label);

    document.body.appendChild(switchBox);
})();

// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem("jovie_theme", themeName);
    document.documentElement.className = themeName;
}
// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem("jovie_theme") === "theme-dark") {
        setTheme("theme-light");
    } else {
        setTheme("theme-dark");
    }
}
