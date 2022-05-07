require('./bootstrap');
// require('./jquery-3.6.0.min');
global.$ = global.jQuery = require('jquery');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
