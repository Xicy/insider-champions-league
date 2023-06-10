<template>
    <div class="col-span-1 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
        <div class="flex justify-between items-center space-x-2 py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
            <h3 class="font-medium">
                Week {{ week_number }}
            </h3>
            <div v-if="showMoveButtons" className="-my-4">
                <button type="button"
                    @click="emitPrevious"
                    className="inline-flex justify-center items-center space-x-2 border border-r-0 rounded-e-none font-semibold rounded-lg p-2 leading-3 text-sm border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                    <svg class="inline-block w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/></svg>
                </button>
                <button type="button"
                    @click="emitNext"
                    className="inline-flex justify-center items-center space-x-2 border border-l-0 rounded-s-none font-semibold rounded-lg p-2 leading-3 text-sm border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                        <svg class="inline-block w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/></svg>
                </button>
            </div>
        </div>

        <div class="p-5 grow">
            <table class="min-w-full text-sm align-middle whitespace-nowrap">
                <tbody>
                    <tr class="border-b border-gray-100 dark:border-gray-700/50" v-for="match in matches">
                        <td class="p-3">
                            {{ match.home.name }}
                        </td>
                        <td class="p-3">
                            {{ match.home_team_score }}-{{ match.away_team_score }}
                        </td>
                        <td class="p-3 text-end">
                            {{ match.away.name }}
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
</div></template>

<script>
export default {
    props: ['week_number', 'matches', 'showMoveButtons'],
    name: 'Week',
    methods: {
        emitPrevious() {
            this.$emit('previous');
        },
        emitNext() {
            this.$emit('next');
        }
    }
}
</script>
