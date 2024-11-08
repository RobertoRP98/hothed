import './bootstrap';
import searchComponent from './components/searchComponent.vue';

import * as bootstrap from 'bootstrap';

import { createApp } from 'vue';

const app = createApp({});
app.component('search-component', searchComponent);
app.mount('#app'); // Asume que tienes un <div id="app"></div> en tu layout Blade.


window.addEventListener('scroll', reveal);


function reveal(){
    var reveals = document.querySelectorAll('.reveal');

    for(var i=0; i < reveals.length; i++){
        var windowheight = window.innerHeight;
        var revealtop = reveals[i].getBoundingClientRect().top;
        var revealpoint = 150;

        if(revealtop < windowheight - revealpoint){
            reveals[i].classList.add('active');
        }
        else{
            reveals[i].classList.remove('active');
        }
    }
}

