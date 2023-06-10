<template>
    <header id="page-header" class="flex flex-none items-center shadow-sm z-1 bg-white dark:bg-gray-800">
        <div class="container xl:max-w-7xl mx-auto px-4 lg:px-8">
            <div class="flex justify-between py-4">
                <div class="flex items-center space-x-2 lg:space-x-6 dark">
                    <router-link to="/"
                        class="group inline-flex items-center space-x-2 font-bold text-lg tracking-wide text-gray-700 hover:text-blue-600 active:text-gray-700 dark:font-semibold dark:text-white dark:hover:text-blue-400 dark:active:text-white">
                        <img src="../../assets/imgs/logo-old.png" :class="{ 'h-9': true, 'invert': dark }" />
                    </router-link>
                </div>
                <div class="flex items-center space-x-2">
                    <button @click="toggleDarkMode"
                        class="inline-flex justify-center items-center space-x-2 border font-semibold rounded-lg px-3 py-2 leading-5 text-sm border-gray-200 bg-white text-gray-800 hover:border-gray-300 hover:text-gray-900 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25 active:border-gray-200 active:shadow-none dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-600 dark:hover:text-gray-200 dark:focus:ring-gray-600 dark:focus:ring-opacity-40 dark:active:border-gray-700">
                        <svg v-if="!dark" class="inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                            <path
                                d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278z" />
                        </svg>
                        <svg v-if="dark" class="inline-block w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 16 16" aria-hidden="true">
                            <path
                                d="M8 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>
</template>

<script>
export default {
    name: 'Header',
    data() {
        return {
            dark: false
        };
    },
    created() {
        if (localStorage.hasOwnProperty('dark')) {
            this.dark = JSON.parse(localStorage.dark) ? true : false;
            const element = document.body;
            if (this.dark) {
                element.classList.add('dark');
            } else {
                element.classList.remove('dark');
            }
        } else {
            this.dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
    },
    methods: {
        toggleDarkMode() {
            const element = document.body;
            const hasDark = element.classList.contains('dark');
            if (hasDark) {
                element.classList.remove('dark');
            } else {
                element.classList.add('dark');
            }
            localStorage.dark = this.dark = !hasDark;
        }
    }
}
</script>
