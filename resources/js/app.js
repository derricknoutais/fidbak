
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import vSelect from 'vue-select'
import VueCurrencyFilter from 'vue-currency-filter';

Vue.component('v-select', vSelect)

import Multiselect from 'vue-multiselect';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);


Vue.component('multiselect', Multiselect)

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('reporting-renseignement', require('./components/Fiche-Renseignement/Reporting.vue').default);
Vue.component('formulaire', require('./components/Fiche-Renseignement/Formulaire.vue').default);
Vue.component('fiches-de-renseignement', require('./components/Fiche-Renseignement/FichesRenseignement.vue').default);
Vue.component('show-fiche', require('./components/Fiche-Renseignement/ShowFiche.vue').default);

Vue.component('sub-index', require('./components/Sub/SubIndex.vue').default);
Vue.component('sub-create', require('./components/Sub/SubCreate.vue').default);
Vue.component('sub-reporting', require('./components/Sub/SubReporting.vue').default);

Vue.use(VueCurrencyFilter,
    {
        symbol: 'F CFA ',
        thousandsSeparator: '.',
        fractionCount: 0,
        fractionSeparator: ',',
        symbolPosition: 'back',
        symbolSpacing: true
    })

const app = new Vue({
    el: '#app',
    mounted(){
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    }
});
