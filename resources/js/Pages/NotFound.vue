<template>
    <div
        class="flex items-center justify-center rounded-xl bg-gray-50 border-2 border-dashed border-gray-200 text-gray-400 dark:bg-gray-800 dark:border-gray-700">
        <div class="relative text-center space-y-16 container xl:max-w-7xl mx-auto px-8 py-16 lg:py-32">
            <div>
                <div class="mb-5 text-rose-300 dark:text-rose-300/50">
                    <svg class="hi-outline hi-document-magnifying-glass inline-block w-12 h-12"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9zm3.75 11.625a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
                <div class="text-6xl md:text-7xl font-extrabold text-rose-600 dark:text-rose-500">
                    404
                </div>
                <div class="w-12 h-1.5 bg-gray-200 rounded-lg mx-auto my-6 md:my-10 dark:bg-gray-700" aria-hidden="true">
                </div>
                <h1 class="text-2xl md:text-3xl font-extrabold mb-3">
                    Well, This is Awkward...
                </h1>
                <h2 class="md:leading-relaxed font-medium text-gray-500 lg:w-3/5 mx-auto mb-5 dark:text-gray-400">
                    Looks like we can't find the page you're looking for.
                    Maybe it's been moved or deleted.
                    Sorry about that!
                </h2>
            </div>
            <router-link to="/"
                class="group inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-3 py-2 leading-5 text-sm border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                <svg class="inline-block w-5 h-5 transition opacity-50 group-hover:opacity-100"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M17 10a.75.75 0 01-.75.75H5.612l4.158 3.96a.75.75 0 11-1.04 1.08l-5.5-5.25a.75.75 0 010-1.08l5.5-5.25a.75.75 0 111.04 1.08L5.612 9.25H16.25A.75.75 0 0117 10z"
                        clip-rule="evenodd" />
                </svg>
                <span>Back to Home</span>
            </router-link>
        </div>
    </div>
</template>
