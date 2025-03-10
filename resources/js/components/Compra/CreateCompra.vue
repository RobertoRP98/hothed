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
                <label class="form-label">DÍAS POR VENCER / VENCIDOS</label>
            </div>
        </div>
    </div>

    <h2>AUTORIZACIONES DE SEGUIMIENTO</h2>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="form-outline">
                <input
                    type="text"
                    v-model="formData.status_requisition"
                    class="form-control"
                    readonly
                />
                <label class="form-label">STATUS DE LA REQUISICIÓN</label>
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
                    <label class="form-label">STATUS DE LA ORDEN</label>
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

    <h2>PRODUCTOS DE LA ORDEN DE COMPRA</h2>
    <!-- Productos de Requisición -->
    <div class="bg-body">
        <div class="card-header">
            Pulse "Agregar" para añadir productos a la requisición
            <button
                class="btn btn-primary float-right"
                @click.prevent="addFields"
            >
                Agregar
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Código Interno</th>
                        <th>UDM</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Impuesto</th>
                        <th>Descuento</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, index) in productData" :key="index">
                        <td>
                            <input
                                type="text"
                                v-model="value.description"
                                @input="searchProducts(index)"
                                class="form-control"
                                placeholder="Busque un producto"
                            />
                            <ul
                                v-if="value.suggestions.length > 0"
                                class="list-group"
                            >
                                <li
                                    v-for="(
                                        product, suggestionIndex
                                    ) in value.suggestions"
                                    :key="suggestionIndex"
                                    @click="selectProduct(index, product)"
                                    class="list-group-item"
                                >
                                    {{ product.description }}
                                </li>
                            </ul>
                        </td>
                        <td>
                            <input
                                type="text"
                                v-model="value.internal_id"
                                class="form-control"
                                placeholder="C-I"
                                readonly
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                v-model="value.udm"
                                class="form-control"
                                placeholder="UDM"
                                readonly
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.quantity"
                                class="form-control"
                                placeholder="Cantidad"
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.price"
                                class="form-control"
                                placeholder="Precio unitario"
                            />
                        </td>

                        <td>
                            <input
                                type="text"
                                :value="value.tax ? value.tax.concept : 'N/A'"
                                class="form-control"
                                placeholder="Impuesto"
                                readonly
                            />
                        </td>

                        <td>
                            <input
                                type="number"
                                v-model="value.discount"
                                class="form-control"
                                placeholder="Descuento"
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.subtotalproducto"
                                class="form-control"
                                placeholder="Importe"
                                readonly
                            />
                        </td>
                        <td>
                            <button
                                class="btn btn-danger"
                                @click.prevent="removeField(index)"
                            >
                                Remover
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>SUB-TOTAL</td>
                        <td>{{ "$" + subtotal + " " + formData.currency }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>TOTAL IVA</td>
                        <td>
                            {{
                                "$" + total_impuestos + " " + formData.currency
                            }}
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>TOTAL DESCUENTO</td>
                        <td>
                            {{
                                "$" + total_descuento + " " + formData.currency
                            }}
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "OrderComponent",
    props: {
        initialData: Object,
        defaultRequestDate: String,
        required: true,
    },
    mounted() {
        if (this.initialData) {
            this.formData = { ...this.initialData.formData }; // Carga todo lo que venga de PHP
            console.log("Datos iniciales recibidos:", this.formData);
        }
        console.log("Datos iniciales:", this.formData);
        console.log("Datos iniciales recibidos:", this.initialData);
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
                days_remaining_now: "",
                status_requisition: "",
                authorization_2: "Pendiente",
                authorization_3: "Pendiente",
                authorization_4: "Pendiente",
                delivery_condition: "100% Antes Entrega",
                po_status: "Pendiente de Pago",
                bill: "Pendiente Facturar",
                subtotal: 0, //guarda el subtotal de todos los subtotalproducto
                total_descuento: 0,
                total_impuestos: 0,
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
            //DATOS DEL PRODUCTO
            productData: [
                {
                    product_id: "", //descripcion
                    internal_id: "", //codigo interno
                    udm: "", //unindad de medida
                    quantity: "", //cantidad
                    price: "", //precio
                    tax_id: null, //impuesto
                    discount: 0, //descuento
                    subtotalproducto: "", //subtotal
                    suggestions: [],
                },
            ],
        };
    },
    methods: {
        //METODOS DE PROVEEDOR
        searchSupplier(index) {
            if (!this.supplierData[index]) return; // Evita errores si no existe

            const query = this.supplierData[index].name;

            //  Si el usuario borra el texto, también limpiamos el ID
            if (!query) {
                this.supplierData[index].supplier_id = ""; // Limpia el ID
                this.supplierData[index].udm = ""; // Limpia el campo udm
                this.supplierData[index].internal_id = ""; // limpia el codigo interno

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
        //FIN DE METODOS PARA PROVEEDORES

        //INICIAN METODOS PARA PRODUCTOS
        addFields() {
            this.productData.push({
                product_id: "",
                description: "",
                quantity: "",
                discount: 0,
                tax_id: "",
                suggestions: [],
            });
        },
        removeField(index) {
            // Aseguramos que todos los valores del producto se limpien antes de eliminarlo
            this.productData[index].description = "";
            this.productData[index].internal_id = "";
            this.productData[index].udm = "";
            this.productData[index].tax_id = "";

            this.productData.splice(index, 1);
        },
        searchProducts(index) {
            const query = this.productData[index].description;
            // 🔹 Si el usuario borra el texto, también limpiamos el ID
            if (!query) {
                this.productData[index].product_id = "";
                this.productData[index].suggestions = [];
                return;
            }
            if (query.length < 2) {
                this.productData[index].suggestions = [];
                return;
            }
            axios
                .get("/api/product-requisition", { params: { query } })
                .then((response) => {
                    this.productData[index].suggestions = response.data;
                });
        },
        selectProduct(index, product) {
            this.productData[index].product_id = product.id; // Guardar ID
            this.productData[index].description = product.description; // Mostrar descripción
            this.productData[index].internal_id = product.internal_id; // Autocompletar código interno
            this.productData[index].udm = product.udm; // Autocompletar unidad de medida
            this.productData[index].tax_id = product.tax
                ? product.tax.id
                : null; // 🔹 Asigna el ID del impuesto
            this.productData[index].tax = product.tax ? product.tax : null; // 🔹 Guarda el objeto completo
            this.productData[index].suggestions = []; // Limpiar sugerencias
            console.log("Producto seleccionado:", this.productData[index]);
        },

        //FINALIZA METODOS PARA PRODUCTOS
    },

    watch: {
        productData: {
            handler(newVal) {
                newVal.forEach((product) => {
                    product.subtotalproducto =
                        parseFloat(product.quantity || 0) *
                        parseFloat(product.price || 0);
                });
            },
            deep: true,
        },
    },

    computed: {
        subtotal() {
            return this.productData?.length
                ? this.productData.reduce(
                      (acc, product) => acc + (product.subtotalproducto || 0),
                      0
                  )
                : 0;
        },

        total_impuestos() {
            return this.productData?.length
                ? this.productData.reduce((acc, product) => {
                      const tasaImpuesto = product.tax
                          ? product.tax.percentage / 100
                          : 0;
                      return (
                          acc + (product.subtotalproducto || 0) * tasaImpuesto
                      );
                  }, 0)
                : 0;
        },

        total_descuento() {
            return this.productData?.length
                ? this.productData.reduce((acc, product) => {
                      const tasaDescuento = product.discount
                          ? product.discount / 100
                          : 0;
                      return (
                          acc + product.quantity * product.price * tasaDescuento
                      );
                  }, 0) // <== Aquí cerramos correctamente el reduce con `0`
                : 0;
        },
    },

    
};
</script>
