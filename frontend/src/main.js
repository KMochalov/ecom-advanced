import { createApp } from 'vue'
import router from './router'
import store from './store'
import axios from "axios";
import toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";
// Vuetify
import 'vuetify/styles'
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import Vuetify from "./Vuetify.vue";
import VueTablerIcons from 'vue-tabler-icons';

axios.defaults.baseURL = process.env.VUE_APP_API_BASE_URL;
//axios.defaults.headers.common['Bearer'] = 'token'
const options = {
    position: POSITION.BOTTOM_CENTER,
    timeout: 5000,
};

const token = localStorage.getItem('authToken');
if (token) {
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
}

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi', // This is already the default value - only for display purposes
    },
    theme: {
        defaultTheme: 'light',
    },
})

//const app = createApp(App);
const app = createApp(Vuetify);
app.use(store);
app.use(router);
app.use(toast,options);
app.use(vuetify);
app.use(VueTablerIcons);
app.config.globalProperties.$http = axios; // Установка axios как глобального свойства
app.mount('#app')
