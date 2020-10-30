<template>
    <div class="container">
        <div v-if="message" class="alert" :class="message.class">
            <p>{{ message.message }}</p>
        </div>

        <h1>Cadastro de Propriedade</h1>

        <form @submit.prevent="onSubmit">
             <div class="row">
                <div class="col col-12 ">
                    <div class="form-group">
                        <label for="email">E-mail do proprietário*</label>
                        <input type="text" id="email" class="form-control" v-model.lazy="$v.form.email.$model" placeholder="Ex: email@exemplo.com" />

                        <p class="error" v-if="errors && !$v.form.email.required">Este campo é obrigatório</p>
                        <p class="error" v-if="errors && !$v.form.email.email">Este campo deve conter um e-mail válido</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-2">
                    <div class="form-group">
                        <label for="zipcode">CEP</label>
                        <input type="text" id="zipcode" class="form-control" v-mask="'#####-###'" v-model="form.zipcode" @blur="searchZipCode" placeholder="00000-00" autocomplete="nope" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col col-8">
                    <div class="form-group">
                        <label for="address">Endereço</label>
                        <input type="text" id="address" class="form-control" v-model.lazy="$v.form.address.$model" />
                        <p class="error" v-if="errors && !$v.form.address.required">Este campo é obrigatório</p>
                    </div>
                </div>
                <div class="col col-2">
                    <div class="form-group">
                        <label for="number">Número</label>
                        <input type="text" id="number" class="form-control" v-model.lazy="form.number" />
                    </div>
                </div>
                <div class="col col-2">
                    <div class="form-group">
                        <label for="complement">Complemento</label>
                        <input type="text" id="complement" class="form-control" v-model.lazy="form.complement" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col col-5">
                        <label for="neighborhood">Bairro</label>
                        <input type="text" id="neighborhood" class="form-control" v-model.lazy="$v.form.neighborhood.$model" />

                        <p class="error" v-if="errors &&!$v.form.neighborhood.required">Este campo é obrigatório</p>
                    </div>
                    <div class="col col-5">
                        <label for="city">Cidade</label>
                        <input type="text" id="city" class="form-control" v-model.lazy="$v.form.city.$model" />

                        <p class="error" v-if="errors &&!$v.form.city.required">Este campo é obrigatório</p>
                    </div>
                    <div class="col col-2">
                        <label for="state">Estado</label>
                        <input type="text" id="state" class="form-control" v-model.lazy="$v.form.state.$model" maxlength="2" />

                        <p class="error" v-if="errors &&!$v.form.state.required">Este campo é obrigatório</p>
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

.input-error input {
    border: 1px solid red;
}
</style>

<script>
    const { required, email } = require('vuelidate/lib/validators');

    export default {
        data() {
            return {
                errors: false,
                message: {},
                form: {
                    email: '',
                    zipcode: '',
                    address: '',
                    number: '',
                    complement: '',
                    neighborhood: '',
                    city: '',
                    state: ''
                }
            }
        },
        validations: {
            form: {
                email: {
                    required,
                    email
                },
                address: {
                    required
                },
                neighborhood: {
                    required
                },
                city: {
                    required
                },
                state: {
                    required
                },
            }
        },
        methods: {
            onSubmit: function() {

                this.errors = this.$v.$invalid;

                if (!this.errors) {
                    axios.post('/api/v1/properties', this.form)
                        .then(
                            (response) => {
                                this.message = {
                                    'class': 'alert-success',
                                    'message': 'Cadastro realizado com sucesso!'
                                }
                                this.$router.push('/');

                            },
                            (error) => {
                                const data = error.response.data.errors;

                                let loop = Object.keys(data)

                                let errors = '';

                                loop.forEach(function(error, index) {
                                    console.log(data, error, index);
                                    errors += ` ${data[error]} `;
                                })

                                this.message = {
                                    'class': 'alert-danger',
                                    'message': `Ocorreu um erro ao enviar a mensagem! ${errors}`
                                }
                            }
                        )
                }

            },
            searchZipCode: function() {
                console.log(this.form.zipcode);
                axios.get(`https://viacep.com.br/ws/${this.form.zipcode}/json`)
                    .then((response) => {
                        const { logradouro, bairro, localidade, uf } = response.data;

                        this.form.address = logradouro;
                        this.form.neighborhood = bairro;
                        this.form.city = localidade;
                        this.form.state = uf;
                    })
            }
        },
        computed: {

        }
    }
</script>
