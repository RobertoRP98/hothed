<template>
    <div class="form-compras">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-header">
                        Productos de Requisición &nbsp;&nbsp;&nbsp;
                        <span class="float-right">
                            <button
                                class="btn btn-primary d-inline float-right"
                                @click.prevent="addFields"
                            >
                                Agregar
                            </button>
                        </span>
                    </div>

                    <div class="card-body">
                        <div v-for="(value, index) in productData" :key="index">
                            <div class="row">
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <h5 class="text-center">Producto</h5>
                                        <input
                                            @input="searchProducts(index)"
                                            type="text"
                                            v-model="value.product_id"
                                            class="form-control"
                                            placeholder="Busque un producto"
                                        />

                                        <ul
                                            v-if="value.suggestions.length > 0"
                                            class="list-group"
                                        >
                                            <li
                                                class="list-group-item"
                                                v-for="(
                                                    product, suggestionIndex
                                                ) in value.suggestions"
                                                :key="suggestionIndex"
                                                @click="
                                                    selectProduct(
                                                        index,
                                                        product
                                                    )
                                                "
                                            >
                                                {{ product.description }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <h5 class="text-center">Cantidad</h5>
                                        <input
                                            type="number"
                                            v-model="value.quantity"
                                            class="form-control"
                                            placeholder="Cantidad del producto"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <button
                                            class="btn btn-danger d-inline float-right"
                                            @click.prevent="removeField(index)"
                                        >
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cierre de card-body -->
                </div>
                <!-- Cierre de card -->
            </div>
            <!-- Cierre de col-md-12 -->
        </div>
        <!-- Cierre de row -->
    </div>
    <!-- Cierre de form-compras -->
</template>

<script>
import ComprasComponent from './ComprasComponent.vue';

import axios from "axios";


export default {
    name: "ComprasComponent",

    data() {
        return {
            productData: [
                {
                    product_id: "",
                    quantity: 0,
                    suggestions: [],
                },
            ],
            formData: {
                user_id:'',
                status_requisition: '',
                importance: '',
                finished: '',
                production_date: '',
                request_date:'',
                days_remaining:'', 

            },
        };
    },
    mounted() {},

    methods: {
        someMethod() {
            console.log(undeclaredVariable); // Esto causa un error.
        }, 

        submitForm() {
            //captura de los campos hijos 
            const itemsRequisition = this.$refs.comprasComponent.productData;
        
        //se empaqueta los datos
        const payload = {
            ...this.formData,
            items_requisition: itemsRequisition,
        }
        axios.post("requisitiones",payload)
        .then((response) => {
            console.log("Requisicion almacenada con exito ", response);
        })
        .catch((error) => {
            console.error("error al enviar la requisicion: ",error.response);
        });
    },


        addFields() {
            this.productData.push({
                product_id: "",
                quantity: 0,
                suggestions: [], // Inicializamos un array vacío de sugerencias para la nueva fila
            });
        },

        removeField(index) {
            if (this.productData.length > 1) {
                this.productData.splice(index, 1);
            } else {
                this.productData = [
                    {
                        product_id: "",
                        quantity: 0,
                        suggestions: [], // Re-inicializamos las sugerencias si se elimina la última fila
                    },
                ];
            }
        },

        searchProducts(index) {
            const query = this.productData[index].product_id;
            // Si el término de búsqueda tiene menos de 2 caracteres, no hacer la búsqueda
            if (query.length < 2) {
                this.productData[index].suggestions = [];
                return;
            }

            // Solicitud al backend
            axios
                .get("/api/product-requisition", {
                    params: { query }, // Cambiar 'query' para que coincida con el backend
                })
                .then((response) => {
                    // Almacenar las sugerencias para el producto en la fila actual
                    this.productData[index].suggestions = response.data;
                })
                .catch((error) => {
                    console.error("Error al buscar productos:", error);
                });
        },

        // Cuando el usuario selecciona un producto de las sugerencias
        selectProduct(index, product) {
            this.productData[index].product_id = product.description; // Establecer el nombre del producto
            this.productData[index].suggestions = []; // Limpiar las sugerencias
        },
    },
};
</script>
