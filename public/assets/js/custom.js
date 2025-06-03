//Numeric Input
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.numeric-input');  // Target all elements with 'numeric-input' class

    inputs.forEach(function(input) {
        // Initial formatting (to display commas when page loads)
        formatInputValue(input);

        // Add event listener for user input
        input.addEventListener('input', function(e) {
            let value = e.target.value;

            // Remove non-numeric characters except for the dot (.)
            value = value.replace(/[^0-9.]/g, '');

            // Split the value into integer and decimal parts
            let parts = value.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            // Join the integer and decimal parts back together
            e.target.value = parts.join('.');
        });
    });

    // Format input value initially
    function formatInputValue(input) {
        input.value = input.value.replace(/[^0-9.]/g, '') // Clean the value
                                .replace(/\B(?=(\d{3})+(?!\d))/g, ',') // Format thousands separator
                                .replace(/(\..*)\./g, '$1'); // Handle multiple dots (keep only one)
    }
});

//Remove comma Numeric Input
document.querySelector('form').addEventListener('submit', function(e) {
    const inputs = document.querySelectorAll('.numeric-input');
    
    inputs.forEach(function(input) {
        // Remove commas before form submission
        input.value = input.value.replace(/,/g, '');
    });
});

document.querySelectorAll(".lang-option").forEach((langOption) => {
  langOption.addEventListener("click", () => {
    // Hapus status active dari semua tombol
    document.querySelectorAll(".lang-option").forEach((btn) => {
      btn.classList.remove("active");
    });

    // Tambahkan status active ke tombol yang diklik
    langOption.classList.add("active");

    // Ambil bahasa yang dipilih
    const selectedLanguage = langOption.getAttribute("data-lang");

    // Redirect ke route Laravel untuk mengubah bahasa
    const switchUrl = `/switch-language/${selectedLanguage}`;
    window.location.href = switchUrl;
  });
});

  
  

    // const langToggler = document.querySelector(".lang-toggler");

    // langToggler.addEventListener("click", (event) => {
    //     const clickedElement = event.target;
    //     if (clickedElement.tagName === "SPAN") {
    //         // Hapus class 'active' dari semua span
    //         langToggler.querySelectorAll("span").forEach((span) => {
    //             span.classList.remove("active");
    //         });

    //         // Tambahkan class 'active' ke span yang diklik
    //         clickedElement.classList.add("active");

    //         // Redirect ke URL berdasarkan atribut value
    //         const targetUrl = clickedElement.getAttribute("value");
    //         if (targetUrl) {
    //             window.location.href = targetUrl;
    //         }
    //     }
    // });

