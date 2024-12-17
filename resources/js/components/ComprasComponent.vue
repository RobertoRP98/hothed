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
                                @click="addFields"
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
                                        <input
                                            type="text"
                                            v-model="value.product_id"
                                            class="form-control"
                                            placeholder="Busque un producto"
                                        />
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
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
                                            @click="removeField(index)"
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
import axios from "axios";

export default {
    data() {
        return {
            productData: [
                {
                    product_id: '',
                    quantity: 0,
                }
            ]
        };
    },
    mounted() {},

    methods: {
        addFields() {
            this.productData.push({
                product_id: '',
                quantity: 0,
            });
        },

        removeField(index){

            if(this.productData.length = 1){

            this.productData.splice(index,1);

            }
        }
    }
};
</script>
