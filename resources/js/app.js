require('./bootstrap');
// require('./jquery-3.6.0.min');

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = window.jQuery = require('jquery');
window.Popper = require('@popperjs/core');
window.bootstrap = require('bootstrap');

Alpine.start();
