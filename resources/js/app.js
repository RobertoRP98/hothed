import './bootstrap';
//Inicia requisiciones
import CreateRequisition from './components/Requisition/CreateRequisition.vue';
import EditRequisition from './components/Requisition/EditRequisition.vue';
import ViewRequisition from './components/Requisition/ViewRequisition.vue';
// Finaliza requisiciones

//Inicia ordenes de compra
import CreateCompra from './components/Compra/CreateCompra.vue';
import EditCompra from './components/Compra/EditCompra.vue';
//Finaliza ordenes de compra




import * as bootstrap from 'bootstrap';

import { createApp } from 'vue';

const app = createApp({});
// Registrar el componente global
//REGISTROS DE REQUISICIONES
app.component('create-requisition', CreateRequisition);
app.component('edit-requisition', EditRequisition);
app.component('view-requisition', ViewRequisition);
//FIN DE REQUISICIONES

//REGISTRO DE COMPRAS
app.component('create-compra',CreateCompra);
app.component('edit-compra',EditCompra);


// Montar la aplicación en el contenedor principal
app.mount('#app');// Asume que tienes un <div id="app"></div> en tu layout Blade.



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



