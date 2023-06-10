<template>
    <div class="space-y-8 dark:text-gray-100">
        <Alert :message="message" />
        <div class="md:flex md:space-x-5" v-for="team in teams">
            <div class="md:flex-none md:w-1/3 text-left pl-5 md:pl-0">
                <h3 class="flex items-center justify-start space-x-2 font-semibold mb-1">
                    <svg class="inline-block w-5 h-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ team.name ?? "Team" }}</span>
                </h3>

                <button type="button" @click="removeTeam(team)"
                    className="inline-flex justify-center items-center space-x-2 border font-semibold rounded-full px-2 leading-5 text-xs  border-rose-200 bg-rose-100 text-rose-800 hover:border-rose-300 hover:text-rose-900 hover:shadow-sm focus:ring focus:ring-rose-300 focus:ring-opacity-25 active:border-rose-200 active:shadow-none dark:border-rose-200 dark:bg-rose-200 dark:hover:border-rose-300 dark:hover:bg-rose-300 dark:focus:ring-rose-500 dark:focus:ring-opacity-50 dark:active:border-rose-200 dark:active:bg-rose-200">
                    <svg class="inline-block w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 16 16" aria-hidden="true">
                        <path
                            d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                    </svg>
                    Remove {{ team.name }}
                </button>
            </div>
            <div
                class="md:w-2/3 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
                <div class="p-5 grow">
                    <div class="space-y-6">
                        <div class="sm:flex sm:items-center sm:space-x-2">
                            <div class="w-full">
                                <label for="username" class="font-medium">Team Name</label>
                                <input type="text" placeholder="Team Name" v-model="team.name"
                                    class="w-full block border placeholder-gray-500 px-3 py-2 leading-6 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-blue-500 dark:placeholder-gray-400">
                            </div>
                            <div>
                                <label for="name" class="font-medium">Team Power</label>
                                <input type="number" placeholder="Team Power" v-model="team.power"
                                    class="w-full block border placeholder-gray-500 px-3 py-2 leading-6 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 dark:bg-gray-800 dark:border-gray-600 dark:focus:border-blue-500 dark:placeholder-gray-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex items-center justify-end rounded-xl bg-gray-50 border-2 border-dashed border-gray-200 text-gray-400 p-2 dark:bg-gray-800 dark:border-gray-700">
            <button type="button" @click="addTeam"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                + Add Team
            </button>
        </div>
        <div class="flex items-center justify-end rounded-xl">
            <button type="button" @click="generateFixture"
                class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-4 py-2 leading-6 border-blue-200 bg-blue-100 text-blue-800 hover:border-blue-300 hover:text-blue-900 hover:shadow-sm focus:ring focus:ring-blue-300 focus:ring-opacity-25 active:border-blue-200 active:shadow-none dark:border-blue-200 dark:bg-blue-200 dark:hover:border-blue-300 dark:hover:bg-blue-300 dark:focus:ring-blue-500 dark:focus:ring-opacity-50 dark:active:border-blue-200 dark:active:bg-blue-200">
                Generate Fixture
                <svg class="inline-block w-5 h-5 ml-1" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 16 16" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                </svg>
            </button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Alert from '../Components/Alert.vue';

export default {
    name: 'TournamentCreate',
    components: { Alert },
    data() {
        return {
            message: "",
            // REMARKS: Predefined teams for demo
            teams: [
                { name: 'Liverpool', power: 67 },
                { name: 'Manchester City', power: 85 },
                { name: 'Chelsea', power: 90 },
                { name: 'Arsenal', power: 72 }
            ]
        };
    },
    methods: {
        addTeam() {
            this.teams.push({});
        },
        removeTeam(team) {
            this.teams.splice(this.teams.indexOf(team), 1);
        },
        async generateFixture() {
            try {
                const { data } = await axios.post('/api/tournaments', { teams: this.teams });
                this.$router.push('/tournament/' + data.id);
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
