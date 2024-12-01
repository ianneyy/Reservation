// Get the checkbox and container elements
const navToggle = document.getElementById("nav-toggle");
const container = document.querySelector(".container");

// Add an event listener to detect checkbox state changes
navToggle.addEventListener("change", () => {
    if (navToggle.checked) {
        // Apply styles when the checkbox is checked
        container.style.position = "absolute";
        container.style.maxWidth = "100vw";
        container.style.left = "var(--navbar-width-min)";
        container.classList.add("navbar-closed");
    } else {
        // Reset styles when the checkbox is unchecked
        container.style.position = "";
        container.style.maxWidth = "";
        container.style.left = "";
        container.classList.remove("navbar-closed");
    }
});
