import ExampleComponent from "./components/ExampleComponent.vue";
import PaymentMethods from "./components/PaymentMethods.vue";
import i18n from "./helpers/i18n";
require('./bootstrap');
import { createApp } from 'vue'
const app = createApp({})
app.component('welcome', ExampleComponent)
app.component('payment-methods', PaymentMethods)
app.use(i18n)
app.mount('#app')
