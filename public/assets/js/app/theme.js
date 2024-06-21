document.addEventListener("DOMContentLoaded", function () {
  "use strict";
  // =================================
  // Tooltip
  // =================================
  const tooltipTriggerList = Array.from(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  tooltipTriggerList.forEach((tooltipTriggerEl) => {
    new bootstrap.Tooltip(tooltipTriggerEl);
  });

  // =================================
  // Popover
  // =================================
  var popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]')
  );
  var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl);
  });
  // =================================
  // Hide preloader
  // =================================
  var preloader = document.querySelector(".preloader");
  if (preloader) {
    preloader.style.display = "none";
  }
  // =================================
  // Increment & Decrement
  // =================================
  var quantityButtons = document.querySelectorAll(".minus, .add");
  if (quantityButtons) {
    quantityButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        var qtyInput = this.closest("div").querySelector(".qty");
        var currentVal = parseInt(qtyInput.value);
        var isAdd = this.classList.contains("add");

        if (!isNaN(currentVal)) {
          qtyInput.value = isAdd
            ? ++currentVal
            : currentVal > 0
              ? --currentVal
              : currentVal;
        }
      });
    });
  }
});

// Function to hide the element
function hideElement(className, time = 4000) {
  var elements = document.querySelectorAll(className);
  if (elements) {
    elements.forEach(element => {
      setTimeout(function() {element.remove();}, time);
    });
  }
}

// Function to hide the element

  var elements = document.querySelectorAll(".toast.show");
  if (elements) {
    elements.forEach(element => {
      setTimeout(function() {element.remove();}, 5000);
    });
  }

