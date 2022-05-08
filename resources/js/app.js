require('./bootstrap');
// require('./jquery-3.6.0.min');
global.$ = global.jQuery = require('jquery');


window.addEventListener('DOMContentLoaded', (event) => {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
