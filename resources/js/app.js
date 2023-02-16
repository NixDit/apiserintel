window.axios = require('axios');
window.$     = window.jQuery = require('jquery');
window.Vue   = require('vue').default; // Vue

// COMPONENTS
Vue.component('example-component', require('./components/ExampleComponent.vue').default); // Example
Vue.component('login-form', require('./components/auth/login/index.vue').default); // Login form
Vue.component('register-form', require('./components/auth/register/index.vue').default); // Register form
Vue.component('new-sale', require('./components/administrator/sales/new_sale.vue').default); // New sale form

// INITIALIZING VUE
const app = new Vue({
    //
}).$mount('#app');
