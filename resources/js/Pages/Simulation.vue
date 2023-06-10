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
                Play All Weeks
            </button>
            <button type="button" @click="playNextWeek" :disabled="calculateDisabledAction()" :class="{
                'inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200': true,
                'cursor-not-allowed': calculateDisabledAction()
            }">
                Play Next Week
            </button>
            <button type="button" @click="reset" class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-red-200 bg-red-100 text-red-800 hover:border-red-300 hover:text-red-900 hover:shadow-sm focus:ring focus:ring-red-300 focus:ring-opacity-25 active:border-red-200 active:shadow-none dark:border-red-200 dark:bg-red-200 dark:hover:border-red-300 dark:hover:bg-red-300 dark:focus:ring-red-500 dark:focus:ring-opacity-50 dark:active:border-red-200 dark:active:bg-red-200">
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
