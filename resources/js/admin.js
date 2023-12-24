import TextEditor from "./components/TextEditor.vue";
import i18n from "./helpers/i18n";
require('./bootstrap-admin');
import { createApp } from 'vue'
const app = createApp({})
app.component('text-editor', TextEditor)

app.use(i18n)
app.mount('#admin')
