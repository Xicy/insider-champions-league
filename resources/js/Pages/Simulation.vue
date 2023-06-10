<template>
    <div class="space-y-8 dark:text-gray-100">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4 lg:gap-8" v-if="teams.length > 0">
            <div
                class="col-span-2 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="font-medium">
                        Fixture
                    </h3>
                </div>
                <div class="p-5 grow">
                    <table class="min-w-full text-sm align-middle whitespace-nowrap">
                        <thead>
                            <tr>
                                <td>
                                    Team Name
                                </td>
                                <td class="text-center">
                                    P
                                </td>
                                <td class="text-center">
                                    W
                                </td>
                                <td class="text-center">
                                    D
                                </td>
                                <td class="text-center">
                                    L
                                </td>
                                <td class="text-center">
                                    GD
                                </td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50" v-for="team in teams"
                                :key="team.id">
                                <td class="p-3">
                                    {{ team.name }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ team.won + team.drawn + team.lost }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ team.won }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ team.drawn }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ team.lost }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ team.goal_difference }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Week :week_number="computedCurrentWeek" :matches="previousWeek" />
            <div
                class="col-span-1 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="font-medium">
                        Championship Predictions
                    </h3>
                </div>
                <div class="p-5 grow">
                    <table class="min-w-full text-sm align-middle whitespace-nowrap">
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50"
                                v-for="prediction in computedPredictions" :key="prediction.team_id">
                                <td class="p-3">
                                    {{ prediction.team.name }}
                                </td>
                                <td class="p-3 text-end">
                                    {{ prediction.chance }} %
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between">
            <button type="button" @click="playAll" :disabled="calculateDisabledAction()" :class="{
                'inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200': true,
                'cursor-not-allowed': calculateDisabledAction()
            }">
                <svg class="inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M7.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C.713 12.69 0 12.345 0 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692Z"/><path d="M15.596 7.304a.802.802 0 0 1 0 1.392l-6.363 3.692C8.713 12.69 8 12.345 8 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692Z"/></svg>
                Play All Weeks
            </button>
            <button type="button" @click="playNextWeek" :disabled="calculateDisabledAction()" :class="{
                'inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200': true,
                'cursor-not-allowed': calculateDisabledAction()
            }">
                <svg class="inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/></svg>
                Play Next Week
            </button>
            <button type="button" @click="reset" class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-red-200 bg-red-100 text-red-800 hover:border-red-300 hover:text-red-900 hover:shadow-sm focus:ring focus:ring-red-300 focus:ring-opacity-25 active:border-red-200 active:shadow-none dark:border-red-200 dark:bg-red-200 dark:hover:border-red-300 dark:hover:bg-red-300 dark:focus:ring-red-500 dark:focus:ring-opacity-50 dark:active:border-red-200 dark:active:bg-red-200">
                <svg class="inline-block w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path d="M9.302 1.256a1.5 1.5 0 0 0-2.604 0l-1.704 2.98a.5.5 0 0 0 .869.497l1.703-2.981a.5.5 0 0 1 .868 0l2.54 4.444-1.256-.337a.5.5 0 1 0-.26.966l2.415.647a.5.5 0 0 0 .613-.353l.647-2.415a.5.5 0 1 0-.966-.259l-.333 1.242-2.532-4.431zM2.973 7.773l-1.255.337a.5.5 0 1 1-.26-.966l2.416-.647a.5.5 0 0 1 .612.353l.647 2.415a.5.5 0 0 1-.966.259l-.333-1.242-2.545 4.454a.5.5 0 0 0 .434.748H5a.5.5 0 0 1 0 1H1.723A1.5 1.5 0 0 1 .421 12.24l2.552-4.467zm10.89 1.463a.5.5 0 1 0-.868.496l1.716 3.004a.5.5 0 0 1-.434.748h-5.57l.647-.646a.5.5 0 1 0-.708-.707l-1.5 1.5a.498.498 0 0 0 0 .707l1.5 1.5a.5.5 0 1 0 .708-.707l-.647-.647h5.57a1.5 1.5 0 0 0 1.302-2.244l-1.716-3.004z"/></svg>
                Reset Data
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Week from './../Components/Week.vue';
import { useRoute } from 'vue-router'

export default {
    name: 'Simulation',
    components: { Week },
    data() {
        return {
            awaiting: false,
            teams: [],
            pairs: [],
            current_week: 1,
            predictions: [
                // { team_id: 1, chance: 10 },
                // { team_id: 2, chance: 20 },
                // { team_id: 3, chance: 30 },
                // { team_id: 4, chance: 40 },
            ]
        };
    },
    async created() {
        const route = useRoute();
        await this.loadResult();
    },
    methods: {
        async loadResult() {
            this.awaiting = true;
            try {
                const { data } = await axios.get(`/api/tournaments/${this.$route.params.id}/simulation/result`);
                this.teams = data.teams;
                this.pairs = data.pairs;
                this.current_week = data.current_week;
            }
            finally {
                this.awaiting = false;
            }
        },
        async playAll() {
            this.awaiting = true;
            try {
                await axios.post(`/api/tournaments/${this.$route.params.id}/simulation/play-all`);
                await this.loadResult();
            }
            finally {
                this.awaiting = false;
            }
        },
        async playNextWeek() {
            this.awaiting = true;
            try {
                await axios.post(`/api/tournaments/${this.$route.params.id}/simulation/play-next-week`);
                await this.loadResult();
            }
            finally {
                this.awaiting = false;
            }
        },
        async reset() {
            this.awaiting = true;
            try {
                await axios.post(`/api/tournaments/${this.$route.params.id}/simulation/reset`);
                await this.loadResult();
            }
            finally {
                this.awaiting = false;
            }
        },
        calculateDisabledAction() {
            return !this.awaiting && this.computedCurrentWeek >= this.computedPairs.length / 2;
        }
    },
    computed: {
        computedPairs() {
            const pairs = this.pairs.map(pair => {
                return {
                    ...pair,
                    home: this.teams.find(team => team.id === pair.home_team_id),
                    away: this.teams.find(team => team.id === pair.away_team_id)
                }
            });
            return pairs;
        },
        computedPredictions() {
            return this.predictions.map(prediction => {
                return {
                    ...prediction,
                    team: this.teams.find(team => team.id === prediction.team_id),
                }
            }).sort((first, second) => second.chance - first.chance);
        },
        computedCurrentWeek() {
            if (this.current_week == 0) {
                return 1
            } else if (this.current_week == -1) {
                return this.pairs[this.pairs.length - 1].week;
            }
            return this.current_week;
        },
        previousWeek() {
            var week = this.computedCurrentWeek - 1;
            if (week == 0) {
                week++;
            }
            return this.computedPairs.filter(pair => pair.week == week);
        }
    }
}
</script>
