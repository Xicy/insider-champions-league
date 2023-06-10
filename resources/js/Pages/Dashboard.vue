<template>
    <div class="space-y-8 dark:text-gray-100">
        <Alert :message="message" />
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-8">
            <div v-for="(tournament, index) in tournaments" :key="tournament.id"
                class="col-span-1 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="font-medium">
                        Tournament {{ tournament.id }}
                    </h3>
                </div>
                <div class="p-5 grow">
                    <router-link :to="'/tournament/' + tournament.id"
                        class="w-full inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                        Show Tournament
                    </router-link>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end rounded-xl" v-if="tournaments?.length > 0">
            <router-link to="/tournament/create"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Create Tournament
            </router-link>
        </div>
        <div v-if="tournaments == null || tournaments?.length == 0"
            class="flex items-center justify-center rounded-xl bg-gray-50 border-2 border-dashed border-gray-200 text-gray-400 py-64 dark:bg-gray-800 dark:border-gray-700">
            <router-link to="/tournament/create"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Create Tournament
            </router-link>
        </div>

    </div>
</template>


<script>
import axios from 'axios';
import Alert from '../Components/Alert.vue';

export default {
    name: 'Dashboard',
    components: { Alert },
    data() {
        return {
            message: "",
            tournaments: []
        };
    },
    async created() {
        await this.loadTournaments();
    },
    methods: {
        async loadTournaments() {
            try {
                const { data } = await axios.get(`/api/tournaments`);
                this.tournaments = data;
            } catch (error) {
                // TODO: Implement error handling
                const { response } = error;
                const { data, status } = response;
                if (status == 422) {
                    const { message } = data;
                    this.message = message;
                    console.log(data);
                } else {
                    console.error(error);
                }
            }
        }
    }
}
</script>
