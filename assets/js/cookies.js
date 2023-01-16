if (document.querySelector('.cookie-popup')) {
    const popup = document.querySelector('.cookie-popup');

    popup.addEventListener('click', function () {
        const crudValue = popup.getAttribute('data-cookie');

        const expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 356);
        document.cookie = `cookie-${crudValue}=true; expires=${expirationDate.toUTCString()};`;

        popup.style.display = 'none';
    });

    const crudValue = popup.getAttribute('data-cookie');

    if (document.cookie.indexOf(`cookie-${crudValue}=true`) === -1) {
        popup.style.display = 'block';
    } else {
        popup.style.display = 'none';
    }
}
