import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router';

import App from './Components/App.vue';
import NotFound from './Pages/NotFound.vue';
import Dashboard from './Pages/Dashboard.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
        { path: '/', component: Dashboard },
    ]
});

const app = createApp(App);
app.use(router);
app.mount('#app');
