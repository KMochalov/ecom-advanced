import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import axios from "axios";
import Toast, { POSITION } from "vue-toastification";
import "vue-toastification/dist/index.css";

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

const app = createApp(App);
app.use(store);
app.use(router);
app.use(Toast,options);
app.config.globalProperties.$http = axios; // Установка axios как глобального свойства
app.mount('#app')
