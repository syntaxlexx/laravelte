<script lang="ts">
    import MainLayout from './MainLayout.svelte'
    import { page } from '@inertiajs/svelte'
    import { Button, Icon, ThemeSwitcher } from '@/Components'
    import { onMount } from 'svelte'
    import { slide } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import AdminSidebar from '@/Components/AdminSidebar.svelte'

    $: auth = $page.props.auth.user

    let isMobile = false
    let isDrawerShown = false
    let x = 0

    $: if (x > 768) {
        isMobile = false
    } else {
        isMobile = true
    }

    onMount(() => {
        isMobile = window.innerWidth < 768
    })

    function closeDrawer() {
        isDrawerShown = false
    }
</script>

<svelte:window bind:innerWidth={x} />

<MainLayout>
    <div class="user-dashboard flex flex-wrap relative">
        <!-- desktop -->
        <div class="hidden md:block md:w-72 h-full bg-gray-100 dark:bg-gray-800">
            <div class="p-5 pt-6">
                <AdminSidebar on:click={closeDrawer} />
            </div>
        </div>

        <!-- mobile -->
        {#if isMobile && isDrawerShown}
            <div
                class="md:hidden absolute w-full h-full z-20"
                in:slide={{ axis: 'x', duration: 300, easing: quintOut }}
            >
                <div class="relative">
                    <div class="w-[100vw] h-[100vh] bg-gray-800/50 dark:bg-gray-600/50" on:click={closeDrawer}>
                        <div class="absolute top-5 right-5">
                            <Icon name="x-circle" classes="text-3xl text-white" />
                        </div>
                    </div>
                    <div class="w-72 z-20 h-full bg-gray-100 dark:bg-gray-800 absolute top-0 left-0">
                        <div class="p-5 pt-6">
                            <AdminSidebar on:click={closeDrawer} />
                        </div>
                    </div>
                </div>
            </div>
        {/if}

        <div class="w-full md:flex-1 bg-white dark:bg-gray-900">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-xl font-semibold">
                    {$page.props.title}
                </h3>
                <div />
                <div class="flex gap-2 items-center">
                    <Icon name="bell" classes="text-2xl text-gray-600 dark:text-gray-300" />
                    <Icon name="message" classes="text-2xl text-gray-600 dark:text-gray-300" />
                    <div class="hidden md:block">
                        <ThemeSwitcher />
                    </div>
                    <div class="hidden md:block">
                        <Button size="sm">Share</Button>
                    </div>
                    <div class="hidden md:block">
                        <Button size="sm" color="secondary">Create</Button>
                    </div>
                    <button
                        type="button"
                        class="inline-flex items-center p-2 text-sm rounded-lg md:hidden lg:hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-primary-200"
                        aria-controls="navbar-sticky"
                        aria-expanded="false"
                        on:click={() => (isDrawerShown = !isDrawerShown)}
                    >
                        <span class="sr-only">Open main menu</span>
                        <svg
                            class="w-6 h-6"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                            ><path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            /></svg
                        >
                    </button>
                </div>
            </div>

            <slot />
        </div>
    </div>
</MainLayout>

<style lang="css">
    .user-dashboard {
        @apply bg-gray-100 dark:bg-gray-800 min-h-screen;
    }
</style>
