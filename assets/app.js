/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// start the Stimulus application
import './bootstrap';

// Sass
import './styles/scss/app.scss';


// Sass
import './js/cookies.js';


function setSideMenuWidth() {
    let sideMenu = document.querySelector('.side-menu');
    const parent = sideMenu.parentElement;

    sideMenu.style.width = `${parent.offsetWidth}px`;
}

if (document.querySelector('.side-menu')){
    window.addEventListener('load', setSideMenuWidth);
    window.addEventListener('resize', setSideMenuWidth);
}

