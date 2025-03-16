import './bootstrap';
import { createApp } from 'vue';


//AXIOS PARA EL TOKEN DE LOS FORM
import axios  from './services/axios';

//Inicia requisiciones
import CreateRequisition from './components/Requisition/CreateRequisition.vue';
import EditRequisition from './components/Requisition/EditRequisition.vue';
import ViewRequisition from './components/Requisition/ViewRequisition.vue';
// Finaliza requisiciones

//Inicia ordenes de compra
import CreateCompra from './components/Compra/CreateCompra.vue';
import EditCompra from './components/Compra/EditCompra.vue';
import ShowCompra from './components/Compra/ShowCompra.vue';
//Finaliza ordenes de compra


if (document.getElementById('app')) {
    const app = createApp({});
    //COMPONENTES DE REQUISICION
    app.component('create-requisition', CreateRequisition);
    app.component('edit-requisition', EditRequisition);
    app.component('view-requisition', ViewRequisition);
    //FINALIZA REQUISICION

    //COMPONENTES DE COMPRAS
    app.component('create-compra', CreateCompra);
    app.component('edit-compra', EditCompra);
    app.component('show-compra', ShowCompra);
    //FINALIZA REQUISICION

    // Montar la aplicación en el contenedor principal
    app.mount('#app');// Asume que tienes un <div id="app"></div> en tu layout Blade.
}