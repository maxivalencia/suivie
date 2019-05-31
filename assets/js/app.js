/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('../css/global.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

require('bootstrap');

//console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
$(function(){
    function notification(){
        // mise en place d'ajax pour récupérer le nombre de message recue
        //let route = "{{ path('notif_non')|escape('js') }}"
        $.get('127.0.0.1:8000/notif_non', function(data){
            // Une ou plusieurs instructions
            $('#non').innerText(data['dataResponse']);
        });
    
        // mise à jout affichage
        
    }
    setInterval(notification, 10000);
});
