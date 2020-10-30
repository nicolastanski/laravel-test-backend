/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { default: Axios } = require('axios');

require('./bootstrap');

window.Vue = require('vue');

const VueRouter = require('vue-router').default;
const Vuelidate = require('vuelidate').default;
const VueMask = require('v-mask').default;

Vue.use(Vuelidate);
Vue.use(VueMask);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

const AppComponent = require('./components/AppComponent.vue').default;
const PropertyList = require('./components/PropertyList.vue').default;
const PropertyRegister = require('./components/PropertyRegister.vue').default;
const ContractList = require('./components/ContractList.vue').default;
const ContractRegister = require('./components/ContractRegister.vue').default;

Vue.component('property-register', PropertyRegister).default

const router = new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: PropertyList },
        { path: '/properties', component: PropertyList },
        { path: '/properties/register', component: PropertyRegister },
        { path: '/contracts', component: ContractList },
        { path: '/contracts/register', component: ContractRegister },
    ]
});


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
    methods: {
      formatDocument: function(document) {
        if (document.length == 11) return document.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");

        return document.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, "$1.$2.$3/$4-$5");
      }
    }
})

const app = new Vue({
    el: '#app',
    components: { AppComponent },
    router
});
