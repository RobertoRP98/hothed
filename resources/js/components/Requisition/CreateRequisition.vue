<template>
    <div>
        <!-- Primera fila -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="form-outline">
                    <select
                        v-model="formData.status_requisition"
                        class="form-select"
                        disabled
                    >
                        <option value="Pendiente">
                            PENDIENTE DE AUTORIZACIÓN
                        </option>
                    </select>
                    <label class="form-label">STATUS DE LA REQUISICIÓN</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <select v-model="formData.importance" class="form-select">
                        <option value="Baja">BAJA</option>
                        <option value="Media">MEDIA</option>
                        <option value="Alta">ALTA</option>
                    </select>
                    <label class="form-label"
                        >PRIORIDAD DE LA REQUISICIÓN</label
                    >
                </div>
            </div>

            <!-- <div class="col-md-3">
                <div class="form-outline">
                    <select v-model="formData.petty_cash" class="form-select">
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                    <label class="form-label">¿CAJA CHICA?</label>
                </div>
            </div> -->

            <div class="col-md-3">
                <div class="form-outline">
                    <select
                        v-model="formData.finished"
                        class="form-select"
                        disabled
                    >
                        <option value="0">NO</option>
                    </select>
                    <label class="form-label">¿REQUISICIÓN FINALIZADA?</label>
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="date"
                        v-model="formData.request_date"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA DE SOLICITUD</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="date"
                        v-model="formData.required_date"
                        class="form-control"
                    />
                    <label class="form-label">FECHA REQUERIDA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="date"
                        v-model="formData.production_date"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA MAX DE ENTREGA</label>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-outline">
                    <input
                        type="number"
                        v-model="formData.days_remaining"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">DÍAS FALTANTES</label>
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
                        placeholder="EJEMPLO: EL MOTIVO DE LA PRIORIDAD"
                    />
                    <label class="form-label">ESCRIBIR NOTA</label>
                </div>
            </div>
        </div>

        <!-- Productos de Requisición -->
        <div class="card mt-2">
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
                    </div>

                    <!-- Input de cantidad -->
                    <div class="col-md-4 mt-2">
                        <input
                            type="number"
                            v-model="value.quantity"
                            class="form-control"
                            placeholder="Cantidad"
                        />
                    </div>

                    <!-- Botón para eliminar producto -->
                    <div class="col-md-4 mt-2">
                        <button
                            class="btn btn-danger"
                            @click.prevent="removeField(index)"
                        >
                            Remover
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-3">
            <button @click="submitForm" class="btn btn-primary">
                Enviar Requisición
            </button>
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
                finished_date: "",

                required_date: "",
                //petty_cash: "0",
                notes_client: "",
                notes_resp: null,
            },
            errors: {},

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
        // Asignar una fecha temporal al campo production_date
        this.formData.request_date = new Date().toISOString().split("T")[0]; // Fecha actual
    },
    methods: {
        addFields() {
            this.productData.push({
                product_id: "",
                description: "",
                quantity: 1,
                suggestions: [],
            });
        },
        removeField(index) {
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
            this.productData[index].suggestions = []; // Limpiar sugerencias
        },
        /** 🔹 Validación antes de enviar el formulario */
        validateForm() {
            this.errors = {}; // Reiniciar errores

            // Validar user_id
            if (!this.formData.user_id) {
                this.errors.user_id = "El usuario es obligatorio.";
            }

            // Validar fechas obligatorias
            if (!this.formData.request_date) {
                this.errors.request_date =
                    "La fecha de solicitud es obligatoria.";

                this.errors = {}; // Reinicia errores antes de validar
                console.log(
                    "Valor de required_date:",
                    this.formData.required_date
                ); // 👀 Ver qué tiene el campo

                if (!this.formData.required_date) {
                    this.errors.required_date =
                        "La fecha requerida es obligatoria.";
                }
            }

            // Validar días restantes como número
            if (
                this.formData.days_remaining === "" ||
                isNaN(this.formData.days_remaining)
            ) {
                this.errors.days_remaining =
                    "Los días restantes deben ser un número.";
            }

            // // Validar caja chica como booleano (0 o 1)
            // if (!["0", "1"].includes(this.formData.petty_cash)) {
            //     this.errors.petty_cash = "Caja chica debe ser 'Sí' o 'No'.";
            // }

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
                });
            }

            return Object.keys(this.errors).length === 0; // Retorna true si no hay errores
        },

        /** 🔹 Enviar formulario solo si pasa la validación */
        submitForm() {
            // 🔹 Validar que todos los productos tengan un ID válido
            const invalidItems = this.productData.filter(
                (item) => !item.product_id
            );

            if (invalidItems.length > 0) {
                alert(
                    "Por favor, selecciona únicamente productos válidos de las sugerencias. " +
                        "Si no aparece el producto que buscas, consulta al área de compras."
                );
                return; // ⛔ Evita que continúe el envío del formulario
            }

            if (!this.validateForm()) {
                alert("Corrige los errores antes de enviar.");
                console.error("Errores de validación:", this.errors);
                return; // 💡 Esto debería detener la ejecución
            }

            console.log("Formulario válido, enviando...");
            // Aquí sigue el envío del request si no hay errores

            const payload = {
                ...this.formData,
                items_requisition: this.productData.map((item) => ({
                    product_id: item.product_id,
                    quantity: item.quantity,
                })),
            };

            axios
                .post("/requisiciones", payload)
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
};
</script>
