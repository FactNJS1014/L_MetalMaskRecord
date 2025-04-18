import { createApp } from 'vue';
import App from './App.vue';
import router from './route.js';
import PrimeVue from 'primevue/config';



const app = createApp(App);
app.use(PrimeVue);
app.use(router);

app.mount('#app');
