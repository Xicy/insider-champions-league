<template>
    <div class="space-y-8 dark:text-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-8">
            <Week v-for="(week, index) in computedFixtures" :week_number="index + 1" :matches="week.matches" />
        </div>
        <div class="flex items-center justify-end rounded-xl">
            <button type="button" @click="startSimulation"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                <svg class="inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg>
                Start Simulation
            </button>
        </div>
    </div>
</template>

<script>
import { useRoute } from 'vue-router'
import axios from 'axios';
import Week from './../Components/Week.vue';

export default {
    name: 'FixtureViewer',
    components: { Week },
    data() {
        return {
            teams: [],
            fixtures: []
        };
    },

    async created() {
        const route = useRoute();
        await this.loadTournament(route.params.id);
    },
    methods: {
        async loadTournament(id) {
            try {
                const { data } = await axios.get(`/api/tournaments/${id}`);
                this.teams = data.teams;
                this.fixtures = data.fixtures;
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
        },
        startSimulation() {
            this.$router.push(`/tournament/${this.$route.params.id}/simulation`);
        }
    },
    computed: {
        computedFixtures() {
            return this.fixtures.map(week => {
                const matches = week.map(match => {
                    return {
                        ...match,
                        home: this.teams.find(team => team.id === match.home_team_id),
                        away: this.teams.find(team => team.id === match.away_team_id)
                    }
                });
                return { ...week, matches }
            })
        }
    }
}
</script>
