<script lang="ts">
    import MainLayout from './MainLayout.svelte'
    import { page } from '@inertiajs/svelte'
    import { onMount } from 'svelte'
    import { slide } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import AdminSidebar from '@/Pages/Admin/Components/AdminSidebar.svelte'

    $: auth = $page.props.auth.user

    let isMobile = false
    let isDrawerShown = false
    let x = 0

    $: if (x > 1028) {
        isMobile = false
    } else {
        isMobile = true
    }

    onMount(() => {
        isMobile = window.innerWidth < 1028
    })

    function closeDrawer() {
        isDrawerShown = false
    }
</script>

<svelte:window bind:innerWidth={x} />

<MainLayout>
    <div class="bg-gray-100 dark:bg-gray-900 min-h-screen flex">
        <!-- desktop -->
        <div class="hidden lg:flex lg:w-64 lg:fixed lg:inset-y-0">
            <!-- Sidebar -->
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center h-16 flex-shrink-0 px-4 bg-gray-900">
                    <!-- <img class="h-8 w-auto" src={$page.props.siteLogo} alt={$page.props.siteName} /> -->
                    <h3 class="text-2xl text-white font-semibold">{$page.props.siteName}</h3>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto bg-gray-800 dark:border-r dark:border-gray-700">
                    <AdminSidebar on:click={closeDrawer} />
                </div>
            </div>
        </div>

        <!-- mobile -->
        {#if isMobile && isDrawerShown}
            <div
                class="fixed inset-0 flex z-40 lg:hidden"
                role="dialog"
                aria-modal="true"
                in:slide={{ axis: 'x', duration: 300, easing: quintOut }}
                out:slide={{ axis: 'x', duration: 200, easing: quintOut }}
            >
                <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" on:click={closeDrawer} />

                <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button
                            type="button"
                            class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            on:click={closeDrawer}
                        >
                            <span class="sr-only">Close sidebar</span>
                            <svg
                                class="h-6 w-6 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <div class="flex-shrink-0 flex items-center px-4">
                        <!-- <img class="h-8 w-auto" src={$page.props.siteLogo} alt={$page.props.siteName} /> -->
                        <h3 class="text-2xl text-white font-semibold">{$page.props.siteName}</h3>
                    </div>
                    <div class="mt-5 flex-1 h-0 overflow-y-auto">
                        <AdminSidebar on:click={closeDrawer} />
                    </div>
                </div>

                <div class="flex-shrink-0 w-14" aria-hidden="true" />
            </div>
        {/if}

        <!-- content -->
        <div class="lg:pl-64 flex flex-col w-0 flex-1">
            <div
                class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800"
            >
                <button
                    type="button"
                    class="px-4 border-r border-gray-200 dark:border-gray-700 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-900 lg:hidden"
                    on:click={() => (isDrawerShown = !isDrawerShown)}
                >
                    <span class="sr-only">Open sidebar</span>
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"
                        />
                    </svg>
                </button>
                <div class="flex-1 px-4 flex justify-between">
                    <div class="flex-1 flex">
                        <form class="w-full flex lg:ml-0" action="#" method="GET">
                            <label for="search-field" class="sr-only">Search</label>
                            <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                                <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                    <svg
                                        class="h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </div>
                                <input
                                    id="search-field"
                                    class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 dark:focus:placeholder-gray-600 focus:ring-0 focus:border-transparent sm:text-sm"
                                    placeholder="Search"
                                    type="search"
                                    name="search"
                                />
                            </div>
                        </form>
                    </div>
                    <div class="ml-4 flex items-center lg:ml-6">
                        <button
                            type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                            >Create</button
                        >
                    </div>
                </div>
            </div>

            <main class="flex-1">
                <div class="py-8 xl:py-10">
                    <div class="px-4 sm:px-6 lg:px-8">
                        <slot />
                    </div>
                </div>
            </main>
        </div>
    </div>
</MainLayout>
