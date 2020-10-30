<template>
    <div class="container">
        <div v-if="message" class="alert" :class="message.class">
            <p>{{ message.message }}</p>
        </div>

        <h1>Cadastro de Contrato</h1>

        <form @submit.prevent="onSubmit">

            <div class="row">
                <div class="col col-8">
                    <div class="form-group">
                        <label for="property_id">Propriedade*</label>
                        <select id="property_id" class="form-control" v-model="$v.form.property_id.$model">
                            <option v-for="property in propertiesFiltred" :key="property.id" :value="property.id">
                                {{ `${property.address}, ${property.number} - ${property.city} - ${property.state}` }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-4">
                    <div class="form-group">
                        <label for="name">Nome*</label>
                        <input type="text" id="name" class="form-control" v-model.lazy="$v.form.name.$model" />
                        <p class="error" v-if="errors && !$v.form.name.required">Este campo é obrigatório</p>
                    </div>
                </div>
                <div class="col col-4">
                    <div class="form-group">
                        <label for="email">E-mail*</label>
                        <input type="text" id="email" class="form-control" v-model.lazy="$v.form.email.$model" placeholder="Ex: email@exemplo.com" />

                        <p class="error" v-if="errors && !$v.form.email.required">Este campo é obrigatório</p>
                        <p class="error" v-if="errors && !$v.form.email.email">Este campo deve conter um e-mail válido</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-4">
                    <div class="form-group">
                        <label for="document_type">Tipo Documento*</label>
                        <select id="document_type" class="form-control" v-model.lazy="$v.form.document_type.$model" @change="changeMask">
                            <option value="cpf">CPF</option>
                            <option value="cnpj">CNPJ</option>
                        </select>
                        <p class="error" v-if="errors && !$v.form.document_type.required">Este campo é obrigatório</p>
                    </div>
                </div>
                <div class="col col-4">
                    <div class="form-group">
                        <label for="document_number">Número Documento*</label>
                        <input type="text" id="document_number" class="form-control" v-mask="document_mask" v-model="$v.form.document_number.$model" ref="document_number" />
                        <p class="error" v-if="errors &&!$v.form.document_number.required">Este campo é obrigatório</p>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
    </div>
</template>

<style>
.error {
  color: red;
}

.input-error > input {
    border: 1px solid red;
}
</style>

<script>
    const { required, email } = require('vuelidate/lib/validators');

    export default {
        data() {
            return {
                properties: [],
                propertiesFiltred: [],
                errors: false,
                message: {},
                document_mask: '###.###.###-##',
                form: {
                    property_id: null,
                    name: null,
                    email: null,
                    document_type: 'cpf',
                    document_number: null,
                }
            }
        },
        validations: {
            form: {
                property_id: {
                    required
                },
                name: {
                    required
                },
                email: {
                    required,
                    email
                },
                document_type: {
                    required
                },
                document_number: {
                    required
                }
            }
        },
        methods: {
            listProperties() {
                axios.get('/api/v1/properties')
                    .then((response) => {
                        console.log(response.data);
                        this.properties = response.data;

                        this.propertiesFiltred = this.properties.filter(property => !property.contract);

                    });
            },
            onSubmit: function() {

                this.errors = this.$v.$invalid;

                if (!this.errors) {
                    axios.post('/api/v1/contracts', this.form)
                        .then(
                            (response) => {
                                this.message = {
                                    'class': 'alert-success',
                                    'message': 'Cadastro realizado com sucesso!'
                                }
                                this.$emit('hasMessage', this.message)

                                this.$router.push('/contracts')

                            },
                            (error) => {
                                const data = error.response.data.message
                                this.message = {
                                    'class': 'alert-danger',
                                    'message': `Ocorreu um erro ao enviar a mensagem! ${data}`
                                }
                            }
                        )
                }

            },
            changeMask: function(element) {
                this.form.document_number = '';

                let document_number = element.target.value;
                if (document_number == 'cnpj') {
                    this.document_mask = '##.###.###/####-##';
                }
            }
        },
        computed: {

        },
        mounted() {
            console.log('App component mounted.');
            this.listProperties();
        }
    }
</script>
