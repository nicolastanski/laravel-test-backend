<template>
    <div class="container">
        <div class="row mt-5">

            <div class="col col-12">

                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h1>Lista de Contratos</h1>
                    <router-link to="/contracts/register" class="btn btn-primary">Adicionar</router-link>
                </div>

                <div v-if="message" class="alert" :class="message.class">
                    <p>{{ message.message }}</p>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <p>Total de Registros: {{ contracts.length }}</p>
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
                        <th>Propriedade</th>
                        <th @click="sort('name')">Nome
                            <i v-if="this.currentSort == 'name' && this.currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="this.currentSort == 'name' && this.currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('email')">E-mail
                            <i v-if="this.currentSort == 'email' && this.currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="this.currentSort == 'email' && this.currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th @click="sort('document_type')">Tipo Documento
                            <i v-if="this.currentSort == 'document_type' && this.currentSortDir == 'asc'" class="fa fa-angle-up"></i>
                            <i v-if="this.currentSort == 'document_type' && this.currentSortDir == 'desc'" class="fa fa-angle-down"></i>
                        </th>
                        <th>Documento</th>
                        <th>Ações</th>
                    </thead>
                    <tbody>
                        <tr v-for="contract in sortData" :key="contract.id">
                            <td>
                                <p v-if="contract.property">
                                {{ `${contract.property.address}, ${contract.property.number} - ${contract.property.city} / ${contract.property.state}` }}
                                </p>
                            </td>
                            <td>{{ contract.name }}</td>
                            <td>{{ contract.email }}</td>
                            <td>{{ contract.document_type | uppercase }}</td>
                            <td>{{ formatDocument(contract.document_number) }}</td>
                            <td>
                                <button class="btn btn-danger" @click="destroyContract(contract.id)"><i class="fa fa-trash"></i> Excluir</button>
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
                contracts: [],
                showModal: false,
                currentSort: 'name',
                currentSortDir: 'asc',
                pageSize: 5,
                currentPage: 1

            }
        },
        methods: {
            listContracts() {
                axios.get('api/v1/contracts')
                    .then((response) => {
                        this.contracts = response.data;
                    });
            },
            destroyContract(id) {
                let check = confirm('Você deseja excluir o registro?');

                if (check) {
                    axios.delete(`api/v1/contracts/${id}`)
                    .then((response) => {
                        this.listContracts();
                    });
                }
            },
            showMessage(receivedMessage) {
                this.message = receivedMessage
            },
            sort: function(column) {
                if(column === this.currentSort) {
                    this.currentSortDir = this.currentSortDir === 'asc' ? 'desc' : 'asc';
                }
                this.currentSort = column;
            },
            nextPage: function() {
                if((this.currentPage * this.pageSize) < this.contracts.length) this.currentPage++;
            },
            prevPage: function() {
                if(this.currentPage > 1) this.currentPage--;
            }

        },
        computed: {
            sortData: function() {
                 return this.contracts.sort((a,b) => {
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
                return Math.ceil(this.contracts.length / this.pageSize);
            },

        },
        filters: {
            uppercase: function(value) {
                if (!value) return ''
                value = value.toString()
                return value.toUpperCase()
            }
        },
        mounted() {
            this.listContracts();
        }
    }
</script>
