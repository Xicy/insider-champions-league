<template>
    <div class="col-span-1 flex flex-col rounded-lg shadow-sm bg-white overflow-hidden dark:text-gray-100 dark:bg-gray-800">
        <div class="py-4 px-5 bg-gray-50 dark:bg-gray-700/50">
            <h3 class="font-medium">
                Week {{ week_number }}
            </h3>
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
    </div>
</template>

<script>
export default {
    props: ['week_number', 'matches'],
    name: 'Week',
}
</script>
