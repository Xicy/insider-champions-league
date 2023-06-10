<template>
    <div class="space-y-8 dark:text-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 lg:gap-8">
            <Week v-for="(week, index) in computedWeeks" :key="week.id" :week_number="index + 1" :matches="week.matches" />
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
import Week from './../Components/Week.vue';

export default {
    name: 'FixtureViewer',
    components: { Week },
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
                    id: 1,
                    matches: [
                        { home_team_id: 4, away_team_id: 1 },
                        { home_team_id: 2, away_team_id: 3 }
                    ]
                },
                {
                    id: 2,
                    matches: [
                        { home_team_id: 2, away_team_id: 4 },
                        { home_team_id: 3, away_team_id: 1 }
                    ]
                },
                {
                    id: 3,
                    matches: [
                        { home_team_id: 4, away_team_id: 3 },
                        { home_team_id: 1, away_team_id: 2 }
                    ]
                },
                {
                    id: 4,
                    matches: [
                        { home_team_id: 1, away_team_id: 4 },
                        { home_team_id: 3, away_team_id: 2 }
                    ]
                },
                {
                    id: 5,
                    matches: [
                        { home_team_id: 4, away_team_id: 2 },
                        { home_team_id: 1, away_team_id: 3 }
                    ]
                },
                {
                    id: 6,
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
