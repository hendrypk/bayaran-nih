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