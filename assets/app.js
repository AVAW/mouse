// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import './anons';

const $ = require('jquery');

$(document).ready(function () {
    $('.modalClose').click(function (e) {
        let $el = $(e.currentTarget);
        $el.closest('.modal').removeClass('is-active');
    });

    // Check for click events on the navbar burger icon
    $('.navbar-burger').click(function () {
        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        $('.navbar-burger').toggleClass('is-active');
        $('.navbar-menu').toggleClass('is-active');
    });
});
