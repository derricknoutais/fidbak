
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import vSelect from 'vue-select'

Vue.component('v-select', vSelect)

import Multiselect from 'vue-multiselect';
Vue.component('multiselect', Multiselect)

Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.component('reporting-renseignement', require('./components/Fiche-Renseignement/Reporting.vue'));
Vue.component('formulaire', require('./components/Fiche-Renseignement/Formulaire.vue'));
Vue.component('fiches-de-renseignement', require('./components/Fiche-Renseignement/FichesRenseignement.vue'));
Vue.component('show-fiche', require('./components/Fiche-Renseignement/ShowFiche.vue'));

Vue.component('sub-index', require('./components/Sub/SubIndex.vue'));
Vue.component('sub-create', require('./components/Sub/SubCreate.vue'));


const app = new Vue({
    el: '#app',
    mounted(){
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    }
});
