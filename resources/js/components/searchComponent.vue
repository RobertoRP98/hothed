<template>
    <div class="search">
        <form class="d-flex">
            <input class="form-control me-2" type="text" v-model="keyword" placeholder="Search" aria-label="Search">
        </form>

        <!-- Renderizamos la tabla usando los datos filtrados -->
        <table class="table table-light mt-3" v-if="tools.data.length > 0">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Familia</th>
                    <th>Descripción</th>
                    <th>N. Serie</th>
                    <th>Base de Op.</th>
                    <th>Status</th>
                    <th>Comentario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tool in tools.data" :key="tool.id">
                    <td>{{ tool.id }}</td>
                    <td>{{ tool.family.name }}</td>
                    <td>{{ tool.description }}</td>
                    <td>{{ tool.serienum }}</td>
                    <td>{{ tool.base.name }}</td>
                    <td>{{ tool.toolstatus.name }}</td>
                    <td>{{ tool.comentary }}</td>
                    <td>
                        <button class="btn btn-warning mb-2">
                            <a :href="'/almacenherramientas/' + tool.id + '/edit'" class="text-white">Editar</a>
                        </button> 
                        <button class="btn btn-primary mb-2">
                            <a :href="'/almacenherramientas/' + tool.id" class="text-white">Ver</a>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-else>
            <p>No hay resultados</p>
        </div>

        <!-- Paginación -->
        <nav v-if="tools.last_page > 1" aria-label="Page navigation">
            <ul class="pagination">
                <!-- Botón "Anterior" -->
                <li class="page-item" :class="{ disabled: tools.current_page === 1 }">
                    <a class="page-link" href="#" @click.prevent="getTools(tools.current_page - 1)">Anterior</a>
                </li>

                <!-- Botones de páginas, mostramos solo 10 a la vez -->
                <li v-for="page in paginationPages" :key="page" class="page-item" :class="{ active: tools.current_page === page }">
                    <a class="page-link" href="#" @click.prevent="getTools(page)">{{ page }}</a>
                </li>

                <!-- Botón "Siguiente" -->
                <li class="page-item" :class="{ disabled: tools.current_page === tools.last_page }">
                    <a class="page-link" href="#" @click.prevent="getTools(tools.current_page + 1)">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keyword: null,
            tools: {
                data: [],
                current_page: 1,
                last_page: 1
            },
            paginationRange: 10 // Mostrar hasta 10 botones a la vez
        };
    },
    computed: {
        // Calcular qué páginas mostrar en la paginación
        paginationPages() {
            const range = [];
            const half = Math.floor(this.paginationRange / 2);
            let start = Math.max(1, this.tools.current_page - half);
            let end = Math.min(this.tools.last_page, start + this.paginationRange - 1);

            // Ajustar `start` si estamos cerca del final
            if (end - start < this.paginationRange) {
                start = Math.max(1, end - this.paginationRange + 1);
            }

            for (let i = start; i <= end; i++) {
                range.push(i);
            }

            return range;
        }
    },
    mounted() {
        this.getTools();
    },
    watch: {
        keyword() {
            this.search();
        }
    },
    methods: {
        getTools(page = 1) {
        if (this.keyword) {
            // Si hay una palabra clave de búsqueda, llamamos al endpoint de búsqueda
            this.search(page);
        } else {
            // Si no hay búsqueda, obtenemos el listado general
            axios.get(`/list?page=${page}`)
                .then(response => {
                    this.tools = response.data;
                });
        };
    },
    search(page = 1) {
        axios.post(`/search?page=${page}`, { keyword: this.keyword, page: page })
            .then(response => {
                this.tools = response.data;
            });
    }
    }
}
</script>
