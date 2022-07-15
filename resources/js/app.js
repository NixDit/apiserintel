window.Vue = require('vue').default; // Vue

// COMPONENTS
Vue.component('example-component', require('./components/ExampleComponent.vue').default); // Example
Vue.component('login-form', require('./components/auth/login/index.vue').default); // Login form
Vue.component('register-form', require('./components/auth/register/index.vue').default); // Register form

// INITIALIZING VUE
const app = new Vue({
    //
}).$mount('#app');
