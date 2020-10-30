<template>
    <div class="container">
        <div class="row mt-5">

            <div class="col col-12">

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1>Lista de Propriedades</h1>
                    <router-link to="/properties/register" class="btn btn-primary">Adicionar</router-link>
                </div>

                <div v-if="message" class="alert" :class="message.class">
                    <p>{{ message.message }}</p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p>Total de Registros: {{ properties.length }}</p>
                    <div class="col col-1">
                        <select class="form-control" v-model="pageSize">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                        </select>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <th @click="sort('email')">E-mail
                            <i v-if="currentSort == 'email' && currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="currentSort == 'email' && currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('address')">Rua
                            <i v-if="currentSort == 'address' && currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="currentSort == 'address' && currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('number')">Número
                            <i v-if="currentSort == 'number' && currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="currentSort == 'number' && currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('city')">Cidade
                            <i v-if="currentSort == 'city' && currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="currentSort == 'city' && currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('state')">Estado
                            <i v-if="currentSort == 'state' && currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="currentSort == 'state' && this.currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th>Status</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        <tr v-for="property in sortData" :key="property.id">
                            <td>{{ property.email }}</td>
                            <td>{{ property.address }}</td>
                            <td>{{ property.number }}</td>
                            <td>{{ property.city }}</td>
                            <td>{{ property.state }}</td>
                            <td>{{ property.contract ? 'Contratado' : 'Não Contratado' }}</td>
                            <td>
                                <button class="btn btn-danger" @click="destroyProperty(property.id)"><i class="fa fa-trash"></i> Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <p>
                    <p>Página: {{ currentPage }} / {{ totalPages }}</p>
                    <button v-if="currentPage > 1" @click="prevPage" class="btn btn-secondary"> <i class="fa fa-angle-left"></i> Anterior </button>
                    <button v-if="currentPage < totalPages" @click="nextPage" class="btn btn-primary"><i class="fa fa-angle-right"></i> Próxima</button>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: '',
                properties: [],
                showModal: false,
                currentSort: 'email',
                currentSortDir: 'asc',
                pageSize: 5,
                currentPage: 1
            }
        },
        methods: {
            listProperties() {
                axios.get('api/v1/properties')
                    .then((response) => {
                        this.properties = response.data;
                    });
            },
            destroyProperty(id) {
                let check = confirm('Você deseja excluir o registro?');

                if (check) {
                    axios.delete(`api/v1/properties/${id}`)
                    .then((response) => {
                        this.listProperties();
                        this.message = {
                            'class': 'alert-success',
                            'message': 'Cadastro excluído com sucesso!'
                        }
                    });
                }
            },
            showMessage(receivedMessage) {
                console.log(receivedMessage);
                this.message = receivedMessage;
            },
            sort: function(column) {
                if(column === this.currentSort) {
                    this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                }
                this.currentSort = column;
            },
            nextPage: function() {
                if((this.currentPage * this.pageSize) < this.properties.length) this.currentPage++;
            },
            prevPage: function() {
                if(this.currentPage > 1) this.currentPage--;
            }
        },
        computed: {
            sortData: function() {
                 return this.properties.sort((a,b) => {
                    let modifier = 1;
                    if(this.currentSortDir === 'desc') modifier = -1;
                    if(a[this.currentSort] < b[this.currentSort]) return -1 * modifier;
                    if(a[this.currentSort] > b[this.currentSort]) return 1 * modifier;
                    return 0;
                }).filter((row, index) => {
                    let start = (this.currentPage - 1) * this.pageSize;
                    let end = this.currentPage * this.pageSize;
                    if(index >= start && index < end) return true;
                });
            },
            totalPages: function() {
                return Math.ceil(this.properties.length / this.pageSize);
            }
        },
        mounted() {
            this.listProperties();
        }
    }
</script>
