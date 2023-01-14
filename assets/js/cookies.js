// Get the cookie-popup element
const popup = document.querySelector('.cookie-popup');

// Add a click event listener to the popup
popup.addEventListener('click', function() {
    // Get the value of the "data-cookie" attribute
    const crudValue = popup.getAttribute('data-cookie');

    // Create a cookie with a key of the value of the "data-cookie" attribute and a value of "true"
    const expirationDate = new Date();
    expirationDate.setDate(expirationDate.getDate() + 356);
    document.cookie = `cookie-${crudValue}=true; expires=${expirationDate.toUTCString()};`;

    // Hide the popup
    popup.style.display = 'none';
});

// Get the value of the "data-cookie" attribute
const crudValue = popup.getAttribute('data-cookie');

// On page load, check for the existence of the cookie with the key of the value of the "data-cookie" attribute
if (document.cookie.indexOf(`cookie-${crudValue}=true`) === -1) {
    // If the cookie doesn't exist, show the popup
    popup.style.display = 'block';
} else {
    // If the cookie exists, hide the popup
    popup.style.display = 'none';
}