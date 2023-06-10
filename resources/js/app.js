import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router';

import App from './Components/App.vue';
import NotFound from './Pages/NotFound.vue';
import Dashboard from './Pages/Dashboard.vue';
import TournamentCreate from './Pages/TournamentCreate.vue';
import FixtureViewer from './Pages/FixtureViewer.vue';


const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
        { path: '/', component: Dashboard },
        { path: '/tournament/create', component: TournamentCreate },
        { path: '/fixture', component: FixtureViewer },
    ]
});

const app = createApp(App);
app.use(router);
app.mount('#app');
