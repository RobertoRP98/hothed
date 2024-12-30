<template>
    <div>
        <!-- Primera fila -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="form-outline">
                    <select
                        v-model="formData.status_requisition"
                        class="form-select"
                        disabled
                    >
                        <option value="Pendiente">
                            PENDIENTE DE AUTORIZACIÓN
                        </option>
                        <option value="Autorizado">AUTORIZADO</option>
                        <option value="Rechazado">RECHAZADO</option>
                    </select>
                    <label class="form-label">STATUS DE LA REQUISICIÓN</label>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-outline">
                    <select
                        v-model="formData.importance"
                        class="form-select"
                        disabled
                    >
                        <option value="Baja">BAJA</option>
                        <option value="Media">MEDIA</option>
                        <option value="Alta">ALTA</option>
                    </select>
                    <label class="form-label"
                        >IMPORTANCIA DE LA REQUISICIÓN</label
                    >
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-outline">
                    <select
                        v-model="formData.finished"
                        class="form-select"
                        disabled
                    >
                        <option value="0">NO</option>
                        <option value="1">SI</option>
                    </select>
                    <label class="form-label">¿REQUISICIÓN FINALIZADA?</label>
                </div>
            </div>
        </div>

        <!-- Segunda fila -->
        <div class="row mb-4">
            <div class="col-md-4">
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

            <div class="col-md-4">
                <div class="form-outline">
                    <input
                        type="date"
                        v-model="formData.production_date"
                        class="form-control"
                        readonly
                    />
                    <label class="form-label">FECHA DE RESPUESTA</label>
                </div>
            </div>

            <div class="col-md-4">
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

        <!-- Productos de Requisición -->
        <div class="card mt-2">
            <div class="card-header">
                Productos de Requisición
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
                    {{ value }}
                    <!-- Temporal para depurar -->
                    <input type="text" v-model="value.product_id" />

                    <div class="col-md-4 mt-2">
                        <input
                            type="text"
                            v-model="value.product_id"
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
                    <div class="col-md-4 mt-2">
                        <input
                            type="number"
                            v-model="value.quantity"
                            class="form-control"
                            placeholder="Cantidad"
                        />
                    </div>
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
        initialData: Object, // Para datos iniciales al editar
        required: true,
    },
    defaultRequestDate: {
        type: String,
        required: true,
    },

    data() {
        return {
            formData: {
                user_id: this.initialData.user_id || "",
                status_requisition: "Pendiente",
                importance: "Baja",
                finished: "0",
                production_date: "this.defaultRequestDate",
                request_date: "",
                days_remaining: "",
            },
            productData: this.initialData.productData || [
                { product_id: "", quantity: 0, suggestions: [] },
            ],
        };
    },
    mounted() {
        this.formData.user_id =
        document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content") || this.formData.user_id;

    console.log("User ID cargado:", this.formData.user_id); // Verificar si el ID está presente
    
        console.log("Datos iniciales:", this.initialData);
        if (this.initialData) {
            this.formData = { ...this.initialData.formData };
            this.productData = [...this.initialData.productData];
        }
        this.formData.user_id =
            document
                .querySelector('meta[name="user-id"]')
                .getAttribute("content") || this.formData.user_id;
    },
    methods: {
        addFields() {
            this.productData.push({
                product_id: "",
                quantity: 0,
                suggestions: [],
            });
        },
        removeField(index) {
            this.productData.splice(index, 1);
        },
        searchProducts(index) {
            const query = this.productData[index].product_id;
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
            this.productData[index].product_id = product.description;
            this.productData[index].suggestions = [];
        },
        submitForm() {
            const payload = {
                ...this.formData,
                items_requisition: this.productData,
            };
            console.log("Payload enviado al backend:", payload); // Verificar qué datos estás enviando
            console.log("Productos de la requisición:", this.productData);

            axios
                .post("/requisiciones", payload)
                .then(() => alert("Requisición enviada"))
                .catch((error) =>
                    console.error("Error al enviar datos:", error.response.data)
                ); // Capturar el error completo
        },
    },
};
</script>
