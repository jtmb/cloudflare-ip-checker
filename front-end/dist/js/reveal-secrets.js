document.addEventListener("DOMContentLoaded", function() {
    const toggleButton = document.getElementById("toggleButton");
    const datagridContents = document.querySelectorAll(".datagrid-content");
  
    toggleButton.addEventListener("click", function(event) {
      event.preventDefault();
  
      datagridContents.forEach(content => {
        content.classList.toggle("hidden");
      });
  
      if (datagridContents[0].classList.contains("hidden")) {
        toggleButton.textContent = "Show Secrets";
      } else {
        toggleButton.textContent = "Hide Secrets";
      }
    });
  });