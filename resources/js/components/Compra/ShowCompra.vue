<template>
    <h2>DATOS GENERALES</h2>
    <div class="row mb-4">
        <div class="col-md-2">
            <span class="form-control-plaintext form-outline">
                {{ supplierData[0].name }}
            </span>
            <label class="form-outline">PROVEEDOR</label>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext form-outline">
                    {{ formData.type_op }}
                </span>
                <label class="form-label">TIPO DE COMPRA</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{ formData.payment_type }}
                </span>
                <label class="form-label">METODO DE PAGO</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{ formData.unique_payment == 1 ? "SI" : "NO" }}
                </span>
                <label class="form-label">¿PAGO UNICO?</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{ formData.quotation}}
                </span>
                <label class="form-label">COTIZACIÓN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{ formData.currency }}
                </span>
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
                    readonly
                />
                <label class="form-label">INICIO DE ORDEN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{ formData.finished == 1 ? "SI" : "NO" }}
                </span>
                <label class="form-label">¿FINALIZADO?</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.date_end"
                    class="form-control"
                    readonly
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
                    readonly
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
                <span class="form-control-plaintext">
                    {{ formData.status_requisition }}
                </span>
                <label class="form-label">STATUS DE LA REQUISICIÓN</label>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-outline">
                <span class="form-control-plaintext">
                    {{
                        formData.authorization_2 === "Pendiente"
                            ? "PENDIENTE AUTORIZACIÓN"
                            : formData.authorization_2 === "Autorizado"
                            ? "AUTORIZADO"
                            : formData.authorization_2 === "Rechazado"
                            ? "RECHAZADO"
                            : "N/A"
                    }}
                </span>

                <label class="form-label">PRE AUTORIZACIÓN</label>
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
                <span class="form-control-plaintext">
                    {{
                        formData.authorization_2 === "Pendiente"
                            ? "PENDIENTE AUTORIZACIÓN"
                            : formData.authorization_2 === "Autorizado"
                            ? "AUTORIZADO"
                            : formData.authorization_2 === "Rechazado"
                            ? "RECHAZADO"
                            : "N/A"
                    }}
                </span>
                <label class="form-label">DIRECCIÓN GENERAL</label>
            </div>
        </div>

        <h2>SEGUIMIENTO DE LA COMPRA</h2>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-outline">
                    <span class="form-control-plaintext">
                    {{ formData.delivery_condition }}
                </span>
                    <label class="form-label">CONDICIÓN DE ENTREGA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <span class="form-control-plaintext">
                    {{ formData.po_status }}
                </span>
                    <label class="form-label">STATUS DE LA ORDEN</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <span class="form-control-plaintext">
                    {{ formData.bill }}
                </span>
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
                                readonly
                            />
                            
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
                                readonly
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.price"
                                class="form-control"
                                placeholder="Precio unitario"
                                readonly
                            />
                        </td>

                        <td>
                            <input
                                type="text"
                                :value="value.tax?.concept || 'N/A'"
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
                                readonly
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
                       
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>SUB-TOTAL</td>
                        <td>
                            <span
                                >${{ subtotal.toFixed(2) }}
                                {{ formData.currency }}</span
                            >
                            <input
                                type="hidden"
                                v-model="subtotal"
                                name="subtotal"
                                ref="subtotalInput"
                            />
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
                        <td>IVA</td>
                        <td>
                            <span
                                >${{ total_impuestos.toFixed(2) }}
                                {{ formData.currency }}</span
                            >
                            <input
                                type="hidden"
                                v-model="total_impuestos"
                                name="total_impuestos"
                                ref="totalImpuestosInput"
                            />
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
                        <td>DESCUENTO</td>
                        <td>
                            <span
                                >${{ total_descuento.toFixed(2) }}
                                {{ formData.currency }}</span
                            >
                            <input
                                type="hidden"
                                v-model="total_descuento"
                                name="total_descuento"
                                ref="totalDescuentoInput"
                            />
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
                        <td>TOTAL</td>
                        <td>
                            <span
                                >${{ total.toFixed(2) }}
                                {{ formData.currency }}</span
                            >
                            <input
                                type="hidden"
                                v-model="total"
                                name="total"
                                ref="totalInput"
                            />
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
            this.supplierData = [...this.initialData.supplierData]; // ✅ Asegura que supplierData tenga el proveedor correcto
            this.productData = [...this.initialData.productData]; // ✅ Esto sí funciona
        }
        console.log("Datos iniciales recibidos:", this.formData);
        console.log("Datos iniciales:", this.formData);
        console.log("Datos iniciales recibidos:", this.initialData);
        console.log("Supplier Data:", this.supplierData);
    },
    data() {
        return {
            //DATOS GENERALES DEL FORMULARIO - OC MODEL
            formData: {
                order: "",
                requisition_id: "",
                type_op: "Local", //
                payment_type: "TRANSFERENCIA",
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
                po_status: "PENDIENTE DE PAGO",
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
                    rfc: "",
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

    watch: {
        productData: {
            handler(newVal) {
                let subtotal = 0;
                newVal.forEach((product) => {
                    product.subtotalproducto =
                        parseFloat(product.quantity || 0) *
                        parseFloat(product.price || 0);
                    subtotal += product.subtotalproducto; // Acumula el subtotal total
                });

                // Actualiza formData de una sola vez
                this.formData.subtotal = isNaN(subtotal) ? 0 : subtotal;
                this.formData.total_descuento = isNaN(this.total_descuento)
                    ? 0
                    : this.total_descuento;
                this.formData.total_impuestos = isNaN(this.total_impuestos)
                    ? 0
                    : this.total_impuestos;
                this.formData.total = isNaN(this.total) ? 0 : this.total;
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
                      let tasaImpuesto = 0;

                      // Verifica que product.tax sea un objeto y tenga un percentage válido
                      if (
                          product.tax &&
                          typeof product.tax === "object" &&
                          !isNaN(product.tax.percentage)
                      ) {
                          tasaImpuesto = product.tax.percentage / 100;
                      }

                      return (
                          acc + (product.subtotalproducto || 0) * tasaImpuesto
                      );
                  }, 0)
                : 0;
        },

        total_descuento() {
            return this.productData?.length
                ? this.productData.reduce((acc, product) => {
                      const quantity = parseFloat(product.quantity) || 0;
                      const price = parseFloat(product.price) || 0;
                      const discount = parseFloat(product.discount) || 0;
                      const tasaDescuento = discount / 100;

                      return acc + quantity * price * tasaDescuento;
                  }, 0)
                : 0;
        },

        total() {
            return (
                (this.subtotal || 0) +
                (this.total_impuestos || 0) -
                (this.total_descuento || 0)
            );
        },
    },
};
</script>
