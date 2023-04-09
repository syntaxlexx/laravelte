<script lang="ts">
    import MainLayout from './MainLayout.svelte'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import { LightSwitch, type ModalSettings, modalStore, type ToastSettings, toastStore } from '@skeletonlabs/skeleton'

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

        const confirm: ModalSettings = {
            type: 'confirm',
            title: 'Logout?',
            body: 'Are you sure you want to logout?',
            response: (r: boolean) => {
                if (r) {
                    $form.post(route('logout'), {
                        onSuccess: () => {
                            const t: ToastSettings = {
                                message: 'Logged out',
                                background: 'variant-filled-success',
                            }
                            toastStore.trigger(t)
                        },
                    })
                }
            },
        }

        modalStore.trigger(confirm)
    }
</script>

<svelte:window bind:scrollY={y} />

<MainLayout>
    <nav
        class="px-2 sm:px-4 py-2.5 fixed w-full z-20 top-0 left-0 border-b border-primary-50 dark:border-primary-800 transition-all duration-300 ease-in-out {hasScrolled ||
        !isNavCollapsed
            ? 'bg-surface'
            : ''}"
    >
        <div class="relative">
            <!-- <div class="absolute top-0 left-0 right-0 bottom-0 bg-white opacity-90" /> -->
            <div class="container flex z-10 flex-wrap items-center justify-between mx-auto">
                <a href="/" use:inertia class="flex items-baseline no-underline">
                    <span class="self-center text-xl font-semibold whitespace-nowrap text-token"
                        >{$page.props.siteName}</span
                    >
                </a>
                <div class="flex items-center md:order-2">
                    <div class="mx-2 lg:mr-8">
                        <LightSwitch />
                    </div>

                    <span class="">
                        <a href={route('contact')} use:inertia class="btn btn-sm variant-ghost-surface">
                            <i class="bx bx-support text-[20px]" />
                            Talk to Us
                        </a>
                    </span>

                    <button
                        type="button"
                        class="inline-flex items-center p-2 ml-2 text-sm rounded-lg md:hidden text-primary-token lg:hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-primary-300 dark:focus:ring-primary-700"
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
                                    use:inertia
                                    class="nav-item !text-token"
                                    aria-current="page"
                                    on:click={() => (isNavCollapsed = true)}>{item.title}</a
                                >
                            </li>
                        {/each}

                        {#if auth}
                            <li>
                                <a
                                    href={route('dashboard')}
                                    class="nav-item !text-token"
                                    use:inertia
                                    on:click={() => (isNavCollapsed = true)}>Dashboard ({auth?.email})</a
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
                                <a href={route('login')} use:inertia class="nav-item !text-token">Login</a>
                            </li>
                            <li>
                                <a href={route('register')} use:inertia class="nav-item !text-token">Register</a>
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
    <div class="bg-surface rounded-lg shadow dark:bg-surface-900 m-4">
        <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="/" use:inertia class="mb-4 sm:mb-0 no-underline">
                    <img src="/img/laravelte-logo-full.png" class="h-8 mr-3" alt="logo" />
                    <br />
                    <div class="text-2xl font-semibold whitespace-nowrap text-token">
                        {$page.props.siteName}
                    </div>
                </a>
                <ul
                    class="flex flex-wrap items-center mb-6 text-sm font-medium text-primary-500 sm:mb-0 dark:text-primary-400"
                >
                    <li>
                        <a
                            href={route('about')}
                            class="mr-4 hover:underline md:mr-6 no-underline !text-token"
                            use:inertia>About</a
                        >
                    </li>

                    <li>
                        <a
                            href={route('contact')}
                            class="mr-4 hover:underline md:mr-6 no-underline !text-token"
                            use:inertia>Contact</a
                        >
                    </li>
                    <li>
                        <a
                            href={route('policy-pages', 'privacy-policy')}
                            use:inertia
                            class="mr-4 hover:underline md:mr-6 no-underline !text-token">Privacy Policy</a
                        >
                    </li>
                    <li>
                        <a
                            href="https://ko-fi.com/acelords"
                            target="_blank"
                            class="mr-4 hover:underline md:mr-6 no-underline !text-token">Support Development</a
                        >
                    </li>
                </ul>
            </div>
            <hr class="my-6 lg:my-8" />
            <span class="block text-sm sm:text-center opacity-80"
                >© {new Date().getFullYear()}
                <a href={route('home')} class="hover:underline">{$page.props.siteName}</a>. All Rights Reserved.
                Developed by <a href="https://acelords.com" target="_blank">AceLords</a>
            </span>
        </div>
    </div>
</MainLayout>

<style lang="css">
    nav {
        -webkit-backdrop-filter: blur(8px);
        backdrop-filter: blur(8px);
    }

    .nav-item {
        @apply block py-2 pl-3 pr-4  font-bold rounded hover:bg-surface-100 dark:hover:bg-surface-800 md:hover:bg-transparent dark:md:hover:bg-transparent !no-underline md:hover:!underline md:hover:underline-offset-8 md:p-0 w-full md:w-auto md:border-0 text-left md:text-center;
    }
</style>
