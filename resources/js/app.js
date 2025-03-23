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

//Inicia PREAUTORIZACIONES 
import EditCompraPA from './components/PreautOC/EditCompraPA.vue';
//Finaliza PREAUTORIZACIONES

//Inicia AUTORIZACIONES DE LA DIRECTORA
import EditCompraAut from './components/AutCompra/EditCompraAut.vue';
//FINALIZA AUTORIZACIONES DE LA DIRECTORA


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

    //COMPONENTES DE PRE AUTORIZACION
    app.component('edit-preautorizacion',EditCompraPA);
    //FINALIZA PRE AUTORIZACION

    //COMPONENTE DE AUTORIZACIÓN OC 
    app.component('edit-autorizacion',EditCompraAut);
    //FINALIZA AUTORIZACIÓN OC

    // Montar la aplicación en el contenedor principal
    app.mount('#app');// Asume que tienes un <div id="app"></div> en tu layout Blade.
}