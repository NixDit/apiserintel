// require('./bootstrap');
import { createApp } from 'vue';
// INIT VUE
let app = createApp({});
// COMPONENTS
app.component('login-form',require('./components/auth/login/index.vue').default);
app.component('register-form',require('./components/auth/register/index.vue').default);
// MOUNT
app.mount('#app');