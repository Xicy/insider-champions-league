<template>
    <div class="space-y-8 dark:text-gray-100">
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-4 lg:gap-8">
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
                            <tr class="border-b border-gray-100 dark:border-gray-700/50" v-for="fixture in computedFixture">
                                <td class="p-3">
                                    {{ fixture.team.name }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ fixture.p }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ fixture.w }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ fixture.d }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ fixture.l }}
                                </td>
                                <td class="p-3 text-center">
                                    {{ fixture.gd }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <Week :week_number="computedCurrentWeek.week_number" :matches="computedCurrentWeek.matches" />
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
                                v-for="prediction in computedPredictions">
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
            <button type="button"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Play All Weeks
            </button>
            <button type="button"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Play Next Week
            </button>
            <button type="button"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-red-200 bg-red-100 text-red-800 hover:border-red-300 hover:text-red-900 hover:shadow-sm focus:ring focus:ring-red-300 focus:ring-opacity-25 active:border-red-200 active:shadow-none dark:border-red-200 dark:bg-red-200 dark:hover:border-red-300 dark:hover:bg-red-300 dark:focus:ring-red-500 dark:focus:ring-opacity-50 dark:active:border-red-200 dark:active:bg-red-200">
                Reset Data
            </button>
        </div>
    </div>
</template>

<script>
import Week from './../Components/Week.vue';

export default {
    name: 'Simulation',
    components: { Week },
    data() {
        return {
            teams: [
                { id: 1, name: 'Liverpool', power: 67 },
                { id: 2, name: 'Manchester City', power: 85 },
                { id: 3, name: 'Chelsea', power: 90 },
                { id: 4, name: 'Arsenal', power: 72 }
            ],
            currentWeek: {
                week_number: 1,
                matches: [
                    { home_team_id: 4, away_team_id: 2 },
                    { home_team_id: 1, away_team_id: 3 }
                ]
            },
            fixture: [
                {
                    team_id: 1,
                    p: 1,
                    w: 2,
                    d: 3,
                    l: 4,
                    gd: 5
                },
                {
                    team_id: 2,
                    p: 0,
                    w: 0,
                    d: 0,
                    l: 0,
                    gd: 0
                },
                {
                    team_id: 3,
                    p: 0,
                    w: 0,
                    d: 0,
                    l: 0,
                    gd: 0
                },
                {
                    team_id: 4,
                    p: 0,
                    w: 0,
                    d: 0,
                    l: 0,
                    gd: 0
                }
            ],
            predictions: [
                { team_id: 1, chance: 10 },
                { team_id: 2, chance: 20 },
                { team_id: 3, chance: 30 },
                { team_id: 4, chance: 40 },
            ]
        };
    },
    computed: {
        computedCurrentWeek() {
            const matches = this.currentWeek.matches.map(match => {
                return {
                    ...match,
                    home: this.teams.find(team => team.id === match.home_team_id),
                    away: this.teams.find(team => team.id === match.away_team_id)
                }
            });
            return { ...this.currentWeek, matches }
        },
        computedFixture() {
            return this.fixture.map(item => {
                return {
                    ...item,
                    team: this.teams.find(team => team.id === item.team_id),
                }
            });
        },
        computedPredictions() {
            return this.predictions.map(prediction => {
                return {
                    ...prediction,
                    team: this.teams.find(team => team.id === prediction.team_id),
                }
            }).sort((first, second) => second.chance - first.chance);
        }
    }
}
</script>
