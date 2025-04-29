import { createApp } from 'vue';
import App from './App.vue';
import router from './route.js';
import PrimeVue from 'primevue/config';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup';   // optional
import Row from 'primevue/row'; 
import Aura from '@primeuix/themes/aura'                  // optional
// index.js



const app = createApp(App);
// app.use(PrimeVue);
app.use(router);
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});

app.component('DataTable', DataTable);
app.component('Column', Column);
app.component('ColumnGroup', ColumnGroup);
app.component('Row', Row);

app.mount('#app');
