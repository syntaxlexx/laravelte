<script lang="ts">
    import { Button, ThemeSwitcher } from '@/Components'
    import MainLayout from './MainLayout.svelte'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import Footer from '@/Components/Footer.svelte'
    import { confirmAction } from '@/helpers'
    import { toasts } from 'svelte-toasts'

    $: auth = $page.props.auth.user

    let form = useForm()
    let isNavCollapsed = true
    let y = 0
    let hasScrolled = false

    $: if (y > 100) {
        hasScrolled = true
    } else {
        hasScrolled = false
    }

    type NavItem = {
        title: string
        route: string
    }

    let nav: NavItem[] = [
        {
            title: 'Home',
            route: '/',
        },
        {
            title: 'About',
            route: route('about'),
        },
        {
            title: 'Contact',
            route: route('contact'),
        },
    ]

    function handleLogout(e) {
        isNavCollapsed = true
        e.preventDefault()

        confirmAction('Are you sure you want to logout?', () => {
            $form.post(route('logout'), {
                onSuccess: () => {
                    toasts.success('Logged out')
                },
            })
        })
    }
</script>

<svelte:window bind:scrollY={y} />

<MainLayout>
    <nav
        class="px-2 sm:px-4 py-2.5 fixed w-full z-20 top-0 left-0 border-b border-gray-200 dark:border-gray-700 transition-all duration-300 ease-in-out {hasScrolled ||
        !isNavCollapsed
            ? 'bg-primary-50 dark:bg-primary-900'
            : ''}"
    >
        <div class="relative">
            <!-- <div class="absolute top-0 left-0 right-0 bottom-0 bg-white opacity-90" /> -->
            <div class="container flex z-10 flex-wrap items-center justify-between mx-auto">
                <a href="/" class="flex items-baseline">
                    <!-- <img
                        src={$page.props.siteLogo}
                        class="h-6 w-auto mr-3 sm:h-9 max-w-[11rem] object-contain"
                        alt={$page.props.siteName}
                    /> -->
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-primary-700"
                        >{$page.props.siteName}</span
                    >
                </a>
                <div class="flex items-center md:order-2">
                    <div class="mx-2">
                        <ThemeSwitcher />
                    </div>

                    <span class="hidden sm:block">
                        <a href="/contact">
                            <Button size="sm">
                                <i class="bx bx-support text-[20px]" />
                                Talk to Us</Button
                            >
                        </a>
                    </span>

                    <button
                        type="button"
                        class="inline-flex items-center p-2 text-sm rounded-lg md:hidden lg:hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-primary-200 {hasScrolled
                            ? 'text-primary-500'
                            : 'text-primary-100'}"
                        aria-controls="navbar-sticky"
                        aria-expanded="false"
                        on:click={() => (isNavCollapsed = !isNavCollapsed)}
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
                <div
                    class="items-center justify-between w-full md:flex md:w-auto md:order-1 transition-all duration-300 {isNavCollapsed
                        ? 'hidden'
                        : ''}"
                    id="navbar-sticky"
                >
                    <ul
                        class="flex flex-col p-4 mt-4 rounded-lg md:flex-row md:flex-wrap md:leading-10 md:space-x-8 md:mt-0 md:text-sm md:font-medium"
                    >
                        {#each nav as item}
                            <li>
                                <a
                                    href={item.route}
                                    class="nav-item"
                                    aria-current="page"
                                    on:click={() => (isNavCollapsed = true)}>{item.title}</a
                                >
                            </li>
                        {/each}

                        {#if auth}
                            <li>
                                <a
                                    href={route('dashboard')}
                                    class="nav-item"
                                    use:inertia
                                    on:click={() => (isNavCollapsed = true)}>Dashboard</a
                                >
                            </li>
                            <li>
                                <form on:submit|preventDefault={handleLogout}>
                                    <button type="submit" class="nav-item">
                                        <span class="text-primary-500"> Logout </span>
                                    </button>
                                </form>
                            </li>
                        {:else}
                            <li>
                                <a href="/login" class="nav-item">Login</a>
                            </li>
                        {/if}
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- content -->
    <slot />

    <!-- footer -->
    <Footer />
</MainLayout>

<style lang="css">
    nav {
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
    }

    .nav-item {
        @apply block py-2 pl-3 pr-4 text-primary-700 dark:text-primary-400 font-bold rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-primary-600 dark:md:hover:text-primary-300 md:p-0 w-full md:w-auto border-b border-primary-100 dark:border-primary-700 md:border-0 text-left md:text-center;
    }
</style>
