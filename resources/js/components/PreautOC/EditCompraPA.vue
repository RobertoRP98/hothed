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
                disabled
            />

           
            <label class="form-outline">PROVEEDOR</label>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.type_op" class="form-select" disabled >
                    <option value="Local">LOCAL</option>
                    <option value="Extranjera">EXTRANJERA</option>
                </select>
                <label class="form-label">TIPO DE COMPRA</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.payment_type" class="form-select" disabled>
                    <option value="CREDITO">CREDITO</option>
                    <option value="CAJA CHICA">CAJA CHICA</option>
                    <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                    <option value="AMEX">AMEX</option>
                    <option value="CREDITO">DEBITO</option>
                </select>
                <label class="form-label">METODO DE PAGO</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.unique_payment" class="form-select" disabled>
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
                    disabled
                />
                <label class="form-label">COTIZACIÓN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.currency" class="form-select" disabled>
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
                    disabled
                />
                <label class="form-label">INICIO DE ORDEN</label>
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-outline">
                <input
                    type="text"
                    v-model="formData.days_remaining_now"
                    class="form-control"
                    disabled
                />
                <label class="form-label">DÍAS POR VENCER / VENCIDOS</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <select v-model="formData.finished" class="form-select" hidden>
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                </select>
                <label class="form-label" hidden>¿FINALIZADO?</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.date_end"
                    class="form-control"
                    hidden
                />
                <label class="form-label" hidden>FIN DE ORDEN</label>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-outline">
                <input
                    type="date"
                    v-model="formData.payment_day"
                    class="form-control"
                    hidden
                />
                <label class="form-label" hidden>DIA DE PAGO</label>
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
                    disabled
                />
                <label class="form-label">STATUS DE LA REQUISICIÓN</label>
            </div>
        </div>

       

        <div class="col-md-3">
  <div class="form-outline">
    <select
      v-model="formData.authorization_2"
      class="form-select"
      :class="{
        'bg-warning text-dark': formData.authorization_2 === 'Pendiente',
        'bg-success text-white': formData.authorization_2 === 'Autorizado',
        'bg-danger text-white': formData.authorization_2 === 'Rechazado'
      }"
    >
      <option value="Pendiente">PENDIENTE DE AUTORIZACIÓN</option>
      <option value="Autorizado">AUTORIZADO</option>
      <option value="Rechazado">RECHAZADO</option>
    </select>
    <label class="form-label">PRE-AUTORIZACIÓN</label>
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
                <select v-model="formData.authorization_4" class="form-select" disabled hidden>
                    <option value="Pendiente">PENDIENTE DE AUTORIZACIÓN</option>
                    <option value="Autorizado">AUTORIZADO</option>
                    <option value="Rechazado">RECHAZADO</option>
                </select>
                <label class="form-label" hidden>DIRECTORA GENERAL</label>
            </div>
        </div>

        

        <h2>SEGUIMIENTO DE LA COMPRA</h2>
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="form-outline">
                    <select
                        v-model="formData.delivery_condition"
                        class="form-select"
                        disabled
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
                    <select v-model="formData.po_status" class="form-select" disabled>
                        <option value="PENDIENTE DE PAGO">
                            PENDIENTE DE PAGO
                        </option>
                        <option value="PENDIENTE DE PAGO (SERVICIO CONCLUIDO)">
                            PENDIENTE DE PAGO (SERVICIO CONCLUIDO)
                        </option>
                        <option value="PAGADA">PAGADA</option>
                        <option value="CANCELADA">CANCELADA</option>
                        <option value="EN PAUSA">EN PAUSA</option>
                        <option value="EN PROCESO">EN PROCESO</option>
                    </select>
                    <label class="form-label">STATUS DE LA ORDEN</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <select v-model="formData.bill" class="form-select" disabled>
                        <option value="Pendiente Facturar">
                            PENDIENTE DE FACTURAR
                        </option>
                        <option value="Facturado">FACTURADO</option>
                    </select>
                    <label class="form-label">¿FACTURADO?</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="text"
                        v-model="formData.bill_name"
                        class="form-control"
                        placeholder="FOLIO DE LA FACTURA"
                        disabled
                    />
                    <label class="form-label">FACTURA</label>
                </div>
            </div>
            
        </div>
    </div>

    <h2>PRODUCTOS DE LA ORDEN DE COMPRA</h2>
    <!-- Productos de Requisición -->
    <div class="bg-body">
        <div class="card-header">
            <!-- Pulse "Agregar" para añadir productos a la requisición
            <button
                class="btn btn-primary float-right"
                @click.prevent="addFields"
                disabled
            >
                Agregar
            </button> -->
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Categoria</th>
                        <th>UDM</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Impuesto</th>
                        <th>Descuento</th>
                        <th>Importe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, index) in productData" :key="index">
                        <td>
                            <textarea
                                v-model="value.description"
                                @input="
                                    searchProducts(index);
                                    autoResize(index);
                                "
                                class="form-control"
                                placeholder="Busque un producto"
                                ref="descriptionTextarea"
                                disabled
                            ></textarea>
                         
                        </td>
                        <td>
                            <input
                                type="text"
                                v-model="value.category"
                                class="form-control"
                                placeholder="C-I"
                                disabled
                            />
                        </td>
                        <td>
                            <input
                                type="text"
                                v-model="value.udm"
                                class="form-control"
                                placeholder="UDM"
                                disabled
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.quantity"
                                class="form-control"
                                placeholder="Cantidad"
                                disabled
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.price"
                                class="form-control"
                                placeholder="Precio unitario"
                                disabled
                            />
                        </td>

                        <td>
                            <input
                                type="text"
                                :value="value.tax?.concept || 'N/A'"
                                class="form-control"
                                placeholder="Impuesto"
                                disabled
                            />
                        </td>

                        <td>
                            <input
                                type="number"
                                v-model="value.discount"
                                class="form-control"
                                placeholder="Descuento"
                                disabled
                            />
                        </td>
                        <td>
                            <input
                                type="number"
                                v-model="value.subtotalproducto"
                                class="form-control"
                                placeholder="Importe"
                                disabled
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

        <!-- Botones -->
        <div class="mt-3">
            <button @click="submitForm" class="btn btn-primary">
                Pre-Autorizar Compra
            </button>
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

               // Esperar a que Vue renderice los elementos antes de ajustar los textarea
               this.$nextTick(() => {
                if (this.$refs.descriptionTextarea) {
                    this.$refs.descriptionTextarea.forEach((_, index) => {
                        this.autoResize(index);
                    });
                }
            });
        }
        console.log("Datos iniciales recibidos:", this.formData);
        console.log("Datos iniciales:", this.formData);
        console.log("Datos iniciales recibidos:", this.initialData);
        console.log("Supplier Data:", this.supplierData);
    },
    data() {

        return {
            descriptionTextarea: [],

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
                bill_name:"",
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
                  //  internal_id: "", //codigo interno
                    category:"",
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
        autoResize(index) {
            this.$nextTick(() => {
                const textareas = this.$refs.descriptionTextarea;
                if (textareas && textareas[index]) {
                    const textarea = textareas[index];
                    textarea.style.height = "auto"; // Restablecer altura
                    textarea.style.height = textarea.scrollHeight + "px"; // Ajustar al contenido
                }
            });
        },
        //METODOS DE PROVEEDOR
        searchSupplier(index) {
            if (!this.supplierData[index]) return; // Evita errores si no existe

            const query = this.supplierData[index].name;

            //  Si el usuario borra el texto, también limpiamos el ID
            if (!query) {
                this.supplierData[index].supplier_id = ""; // Limpia el ID
                this.supplierData[index].udm = ""; // Limpia el campo udm
               // this.supplierData[index].internal_id = ""; // limpia el codigo interno
                this.supplierData[index].category = "";
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
            if (!this.supplierData[index]) {
                this.$set(this.supplierData, index, {}); // ✅ Forza la creación del índice
            }
            this.supplierData[index].name = supplier.name;
            this.supplierData[index].suggestions = [];
            this.supplierData[index].supplier_id = supplier.id;

            console.log("Proveedor seleccionado:", this.supplierData[index]);
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
          //  this.productData[index].internal_id = "";
            this.productData[index].category = "";
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
//            this.productData[index].internal_id = product.internal_id; // Autocompletar código interno
            this.productData[index].category = product.category; // Autocompletar código interno
            this.productData[index].udm = product.udm; // Autocompletar unidad de medida
            this.productData[index].tax_id = product.tax
                ? product.tax.id
                : null; // 🔹 Asigna el ID del impuesto
            this.productData[index].tax = product.tax ? product.tax : null; // 🔹 Guarda el objeto completo
            this.productData[index].suggestions = []; // Limpiar sugerencias
            console.log("Producto seleccionado:", this.productData[index]);
        },

        //FINALIZA METODOS PARA PRODUCTOS

        //VALIDACIÓN DE FORMULARIO
        validateForm() {
            this.errors = {}; // Reiniciar errores

           if (!this.formData.supplier_id) {
                this.errors.supplier_id = "El proveedor es obligatorio";
            }

            if (!this.supplierData[0]?.supplier_id) {
                this.errors.supplier_id = "El proveedor es obligatorio.";
            }

            // Validar productos
            if (this.productData.length < 1) {
                this.errors.items_requisition =
                    "Debes agregar al menos un producto.";
            } else {
                this.productData.forEach((item, index) => {
                    if (!item.product_id) {
                        {
                            this.errors[
                                `product_id_${index}`
                            ] = `El producto en la fila ${
                                index + 1
                            } es obligatorio.`;
                        }
                    }
                    if (!item.quantity || item.quantity < 1) {
                        this.errors[
                            `quantity_${index}`
                        ] = `La cantidad en la fila ${
                            index + 1
                        } debe ser mayor a 0.`;
                    }

                    if (!item.price || item.price < 1) {
                        this.errors[`price_${index}`] = `El precio en la fila ${
                            index + 1
                        } debe ser mayor a 0.`;
                    }
                });
            }

            return Object.keys(this.errors).length === 0; // Retorna true si no hay errores
        },
        // FINALIZA VALIDACIÓN DE FORMULARIO

        /** 🔹 Enviar formulario solo si pasa la validación */
        submitForm() {
            if (!this.validateForm()) {
            let errorMessages = Object.values(this.errors).join("\n");
                alert("Corrige los errores antes de enviar.\n\n" + errorMessages);
                console.error("Errores de validacion",this.errors);
                return; // 💡 Esto debería detener la ejecución
            }
            
            if (this.$refs.subtotalInput) {
                this.$refs.subtotalInput.value = this.subtotal;
            }
            if (this.$refs.totalImpuestosInput) {
                this.$refs.totalImpuestosInput.value = this.total_impuestos;
            }
            if (this.$refs.totalDescuentoInput) {
                this.$refs.totalDescuentoInput.value = this.total_descuento;
            }
            if (this.$refs.totalInput) {
                this.$refs.totalInput.value = this.total;
            }
            // 🔹 Validar que todos los productos tengan un ID válido
            const invalidItems = this.productData.filter(
                (item) => !item.product_id
            );

            if (invalidItems.length > 0) {
                alert(
                    "Por favor, selecciona únicamente productos válidos de las sugerencias. " +
                        "Si no aparece el producto que buscas, debe ser dado de alta"
                );
                return; // Evita que continúe el envío del formulario
            }

           

            console.log("Formulario válido, enviando...");
            // Aquí sigue el envío del request si no hay errores

            const payload = {
                ...this.formData,
                requisition_id: this.formData.requisition_id || this.initialData?.formData?.requisition,
                supplier_id: this.supplierData[0]?.supplier_id || null,
                items_order: this.productData.map((item) => ({
                    product_id: item.product_id,
                    price: item.price,
                    discount: item.discount,
                    quantity: item.quantity,
                    subtotalproducto: item.subtotalproducto,
                })),
            };

            console.log("Revisando datos antes de enviar:");
            console.log("Subtotal:", this.formData.subtotal);
            console.log("Total impuestos:", this.formData.total_impuestos);
            console.log("Total descuento:", this.formData.total_descuento);
            console.log("Total:", this.formData.total);
            console.log("Payload:", payload);

            console.log("Datos enviados al backend:", payload); // 🛠️ Depuración
            const requisitionId = this.formData.requisition_id || this.initialData?.formData?.requisition;
            console.log("el ID DE LA REQUI ES ", requisitionId)
            if (!requisitionId) {
                alert("El ID de la requisición no está definido.");
                return;
            }

            const orderId = this.formData.order; // Asegúrate que esté definido
            console.log("el ID DE LA order ES ", orderId)
           
            if (!orderId) {
                alert("El ID de la requisición no está definido.");
                return;
            }

            console.log("Payload antes de enviar:", this.formData);

            axios
                .patch(`/ordenes-compra/${orderId}/requisiciones/${requisitionId}`, payload)
                .then((response) => {
                    console.log("Mensaje:", response.data.message);
                    if (response.data.redirect) {
                        window.location.href = response.data.redirect;
                    }
                })
                .catch((error) => {
                    console.error("Error en la solicitud:", error);
                    alert(
                        "Error: " +
                            (error.response?.data?.message ||
                                "Error desconocido")
                    );
                });
        },
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

<style scoped>
textarea {
    overflow: hidden;
    resize: none; /* Evita que el usuario pueda redimensionarlo */
}
</style>