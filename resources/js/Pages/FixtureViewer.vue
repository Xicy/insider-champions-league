<template>
    <div class="space-y-8 dark:text-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-8">
            <div class="flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800"
                v-for="(week, index) in computedWeeks">
                <div class="py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
                    <h3 class="font-medium">
                        Week {{ index + 1 }}
                    </h3>
                </div>

                <div class="p-5 grow">
                    <table class="min-w-full text-sm align-middle whitespace-nowrap">
                        <tbody>
                            <tr class="border-b border-gray-100 dark:border-gray-700/50"
                                v-for="match in week.matches">
                                <td class="p-3">
                                    {{ match.home.name }}
                                </td>
                                <td class="p-3">
                                    -
                                </td>
                                <td class="p-3 text-end">
                                    {{ match.away.name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end rounded-xl">
            <button type="button" @click="startSimulation"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Start Simulation
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FixtureViewer',
    data() {
        return {
            teams: [
                { id: 1, name: 'Liverpool', power: 67 },
                { id: 2, name: 'Manchester City', power: 85 },
                { id: 3, name: 'Chelsea', power: 90 },
                { id: 4, name: 'Arsenal', power: 72 }
            ],
            weeks: [
                {
                    matches: [
                        { home_team_id: 4, away_team_id: 1 },
                        { home_team_id: 2, away_team_id: 3 }
                    ]
                },
                {
                    matches: [
                        { home_team_id: 2, away_team_id: 4 },
                        { home_team_id: 3, away_team_id: 1 }
                    ]
                },
                {
                    matches: [
                        { home_team_id: 4, away_team_id: 3 },
                        { home_team_id: 1, away_team_id: 2 }
                    ]
                },
                {
                    matches: [
                        { home_team_id: 1, away_team_id: 4 },
                        { home_team_id: 3, away_team_id: 2 }
                    ]
                },
                {
                    matches: [
                        { home_team_id: 4, away_team_id: 2 },
                        { home_team_id: 1, away_team_id: 3 }
                    ]
                },
                {
                    matches: [
                        { home_team_id: 3, away_team_id: 4 },
                        { home_team_id: 2, away_team_id: 1 }
                    ]
                }
            ]
        };
    },
    methods: {
        startSimulation() {
            // TODO: Call Simulation
        }
    },
    computed: {
        computedWeeks() {
            return this.weeks.map(week => {
                const matches = week.matches.map(match => {
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
