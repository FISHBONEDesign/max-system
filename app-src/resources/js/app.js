require('./bootstrap');
var Turbolinks = require('turbolinks');
Turbolinks.start();

if (typeof init_counter === 'undefined') init_counter = 0;
if (typeof Inited === 'undefined') Inited = false;
if (Inited === false) {
    init_window_function();
    init_counter++;
    console.log(`inited ${init_counter} times.`);
}
