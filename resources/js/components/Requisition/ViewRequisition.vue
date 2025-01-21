<template>
    <div>
        <!-- Primera fila -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="statusText"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">STATUS DE LA REQUISICIÓN</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        v-model="formData.importance_now"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">IMPORTANCIA DE LA REQUISICIÓN</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="pettycashText"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">¿CAJA CHICA?</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="finishedText"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">¿REQUISICIÓN FINALIZADA?</label>
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="formattedRequestDate"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA DE SOLICITUD</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="formattedRequiredDate"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA REQUERIDA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        :value="formattedProductionDate"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA MAX DE ENTREGA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        v-model="formData.days_remaining_now"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">DIAS FALTANTES</label>
                </div>
            </div>
        </div>

           <!-- tercera fila -->
           <div class="row mb-4">
            <div class="col-md-6">
                <div class="form-outline">
                    <input
                        type="text"
                        v-model="formData.notes_client"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">NOTAS DEL SOLICITANTE</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-outline">
                    <input
                        type="text"
                        v-model="formData.notes_resp"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">NOTAS DEL RESP DE COMPRAS</label>
                </div>
            </div>

        </div>


        <!-- Productos de Requisición -->
        <div class="card mt-2">
            <div class="card-header">
                Productos de la requisición
               
            </div>
            <div class="card-body">
                <div
                    v-for="(value, index) in productData"
                    :key="index"
                    class="row"
                >
                    <!-- Input de descripción -->
                    <div class="col-md-4 mt-2">
                        <input
                        type="text"
                        v-model="value.description"
                        class="form-control"
                        readonly
                    />
                       
                    </div>

                    <!-- Input de cantidad -->
                    <div class="col-md-4 mt-2">
                        <input
                        type="number"
                        v-model="value.quantity"
                        class="form-control"
                        readonly
                    />
                    </div>

                    <!-- Botón para eliminar producto -->
                    
                </div>
            </div>
        </div>

        
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "ComprasComponent",
    props: {
        initialData: Object,
        required: true,
    },
    data() {
        return {
            formData: {
                user_id: "",
                status_requisition: "Pendiente",
                importance: "Baja",
                finished: "0",
                production_date: "",
                request_date: "",
                days_remaining: "",


                required_date: "",
                petty_cash: "0",
                notes_client: "",
                notes_resp: "",
            },
            productData: [
                {
                    product_id: "",
                    description: "",
                    quantity: 1,
                    suggestions: [],
                },
            ],
        };
    },
    mounted() {
        if (this.initialData) {
            this.formData = { ...this.initialData.formData };
            this.productData = [...this.initialData.productData];
        }
    },

    computed: {
        //Mapeo (buscaqueda del texto) para asignar nuevos valores
        statusText() {
            const statusMap = {
                Pendiente: "PENDIENTE DE AUTORIZACIÓN",
                Autorizado: "AUTORIZADO",
                Rechazado: "RECHAZADO",
            };
            return statusMap[this.formData.status_requisition] || this.formData.status_requisition;
        },
            // boleano a TEXTO

        finishedText(){
                return this.formData.finished === 1 ? "SI" : "NO";
        },
        
        pettycashText(){
                return this.formData.petty_cash === 1 ? "SI" : "NO";
        },



        formattedRequestDate() {
            if (!this.formData.request_date) return "";
            const [year, month, day] = this.formData.request_date.split("-");
            return `${day}-${month}-${year}`;
        },


    formattedProductionDate() {
        if(!this.formData.production_date) return "";
        const [year,month,day] = this.formData.production_date.split("-");
        return `${day}-${month}-${year}`;

    },

    formattedRequiredDate() {
        if(!this.formData.required_date) return "";
        const [year,month,day] = this.formData.required_date.split("-");
        return `${day}-${month}-${year}`;

    },
},

};

</script>