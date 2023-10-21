import ExampleComponent from "./components/ExampleComponent.vue";
import PaymentMethods from "./components/PaymentMethods.vue";

require('./bootstrap');
import { createApp } from 'vue'
const app = createApp({})
app.component('welcome', ExampleComponent)
app.component('payment-methods', PaymentMethods)
app.mount('#app')
