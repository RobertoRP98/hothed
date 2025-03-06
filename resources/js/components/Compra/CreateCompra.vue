<template>
    <h2>DATOS GENERALES</h2>
    <div class="row mb-4">
        <div class="col-md-2">
            <input
                type="text"
                class="form-control"
                v-model="supplierData[0].name"
                @input="searchSupplier(0)"
                placeholder="CAMPO OBLIGATORIO"
            />

            <ul
                v-if="
                    supplierData.length > 0 &&
                    supplierData[0].suggestions.length
                "
                class="list-group"
            >
                <li
                    class="list-group-item"
                    v-for="supplier in supplierData[0].suggestions"
                    :key="supplier.id"
                    @click="selectSupplier(0, supplier)"
                    style="cursor: pointer"
                >
                    {{ supplier.name + " - " + supplier.rfc }}
                </li>
            </ul>
            <label class="form-outline">PROVEEDOR</label>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.type_op" class="form-select">
                    <option value="Local">LOCAL</option>
                    <option value="Extranjera">EXTRANJERA</option>
                </select>
                <label class="form-label">TIPO DE COMPRA</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.payment_type" class="form-select">
                    <option value="Credito">CREDITO</option>
                    <option value="Efectivo">EFECTIVO</option>
                    <option value="Transferencia">TRANSFERENCIA</option>
                    <option value="AMEX">AMEX</option>
                </select>
                <label class="form-label">METODO DE PAGO</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.unique_payment" class="form-select">
                    <option value="1">SI</option>
                    <option value="0">NO</option>
                </select>
                <label class="form-label">¿PAGO UNICO?</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="text"
                    v-model="formData.quotation"
                    class="form-control"
                    placeholder="COTIZACIÓN"
                />
                <label class="form-label">COTIZACIÓN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.currency" class="form-select">
                    <option value="MXN">MXN</option>
                    <option value="USD">USD</option>
                    <option value="EUR">EUR</option>
                </select>
                <label class="form-label">DIVISA</label>
            </div>
        </div>
    </div>

    <h2>FECHAS DE SEGUIMIENTO</h2>
    <div class="row mb-4">
        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.date_start"
                    class="form-control"
                />
                <label class="form-label">INICIO DE ORDEN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.finished" class="form-select">
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
                <label class="form-label">¿FINALIZADO?</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.date_end"
                    class="form-control"
                />
                <label class="form-label">FIN DE ORDEN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.payment_day"
                    class="form-control"
                />
                <label class="form-label">DIA DE PAGO</label>
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

    <h2>AUTORIZACIONES DE SEGUIMIENTO</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="form-outline">
                <input
                    type="text"
                    :value="statusText"
                    class="form-control"
                    placeholder="$oc->requisition->status"
                    readonly
                />
                <label class="form-label">JEFE INMEDIATO</label>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-outline">
                <select v-model="formData.authorization_2" class="form-select">
                    <option value="Pendiente">PENDIENTE DE AUTORIZACIÓN</option>
                    <option value="Autorizado">AUTORIZADO</option>
                    <option value="Rechazado">RECHAZADO</option>
                </select>
                <label class="form-label">FLORES </label>
            </div>
        </div>

        <!-- <div class="col-md-3">
            <div class="form-outline">
                <select v-model="formData.authorization_3" class="form-select">
                    <option value="Pendiente">PENDIENTE DE AUTORIZACIÓN</option>
                    <option value="Autorizado">AUTORIZADO</option>
                    <option value="Rechazado">RECHAZADO</option>
                </select>
                <label class="form-label">IGUAL O MAYOR A 25K</label>
            </div>
        </div> -->

        <div class="col-md-3">
            <div class="form-outline">
                <select v-model="formData.authorization_4" class="form-select">
                    <option value="Pendiente">PENDIENTE DE AUTORIZACIÓN</option>
                    <option value="Autorizado">AUTORIZADO</option>
                    <option value="Rechazado">RECHAZADO</option>
                </select>
                <label class="form-label">DIRECCIÓN GENERAL</label>
            </div>
        </div>

        <h2>SEGUIMIENTO DE LA COMPRA</h2>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-outline">
                    <select
                        v-model="formData.delivery_condition"
                        class="form-select"
                    >
                        <option value="100% Antes Entrega">
                            100% ANTES DE ENTREGA
                        </option>
                        <option value="100% Post Entrega">
                            100% POST ENTREGA
                        </option>
                        <option value="50-50">50 ANTICIPO - 50 ENTREGA</option>
                    </select>
                    <label class="form-label">CONDICIÓN DE ENTREGA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <select v-model="formData.po_status" class="form-select">
                        <option value="Pendiente de Pago">
                            PENDIENTE DE PAGO
                        </option>
                        <option value="Cancelado">CANCELADO</option>
                        <option value="En Transito">EN TRANSITO</option>
                        <option value="En Proceso">EN PROCESO</option>
                    </select>
                    <label class="form-label">CONDICIÓN DE ENTREGA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <select v-model="formData.bill" class="form-select">
                        <option value="Pendiente Facturar">
                            PENDIENTE DE FACTURAR
                        </option>
                        <option value="Facturado">FACTURADO</option>
                    </select>
                    <label class="form-label">¿FACTURADO?</label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "OrderComponent",
    props: {
        initialData: Object,
        required: true,
    },
    data() {
        return {
            //DATOS GENERALES DEL FORMULARIO - OC MODEL
            formData: {
                requisition_id: "",
                type_op: "Local", //
                payment_type: "Transferencia",
                unique_payment: 1,
                quotation: "",
                currency: "MXN",
                date_start: "",
                finished: 0,
                date_end: "",
                payment_day: "",
                status_requisition: "Autorizado",
                authorization_2: "Pendiente",
                authorization_3: "Pendiente",
                authorization_4: "Pendiente",
                delivery_condition: "100% Antes Entrega",
                po_status: "Pendiente de Pago",
                bill: "Pendiente Facturar",
                subtotal: 0,
                total_descuento: 0,
                tax: 0,
                total: 0,
            },
            //DATOS DEL PROVEEDOR - PARA SELECCIONAR EN EL INPUT
            supplierData: [
                {
                    supplier_id: "",
                    name: "",
                    suggestions: [],
                },
            ],
        };
    },
    methods: {
        searchSupplier(index) {
            if (!this.supplierData[index]) return; // Evita errores si no existe

            const query = this.supplierData[index].name;

            //  Si el usuario borra el texto, también limpiamos el ID
            if (!query) {
                this.supplierData[index].supplier_id = ""; // Limpia el ID
                this.supplierData[index].suggestions = [];
                return;
            }

            if (!query || query.length < 2) {
                this.supplierData[index].suggestions = [];
                return;
            }

            axios
                .get("/api/supplier-order", { params: { query } })
                .then((response) => {
                    this.supplierData[index].suggestions = response.data;
                })
                .catch((error) => {
                    console.error("Error en la búsqueda:", error);
                });
        },
        selectSupplier(index, supplier) {
            if (!this.supplierData[index]) return;

            this.supplierData[index].supplier_id = supplier.id;
            this.supplierData[index].name = supplier.name;
            this.supplierData[index].suggestions = [];

            console.log("Proveedor seleccionado:", supplier.id, supplier.name);
        },
    },
};
</script>
