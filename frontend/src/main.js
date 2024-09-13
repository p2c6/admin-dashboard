import './assets/main.css'
import 'datatables.net-dt/css/dataTables.dataTables.min.css';

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(router)
app.use(createPinia())

app.mount('#app')
