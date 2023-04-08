<script>
    import MainLayout from './MainLayout.svelte'
    import { AppBar } from '@skeletonlabs/skeleton'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import { LightSwitch } from '@skeletonlabs/skeleton'

    $: auth = $page.props.auth.user

    let form = useForm()

    function handleLogout(e) {
        e.preventDefault()

        $form.post(route('logout'))
    }
</script>

<MainLayout withShell={true}>
    <svelte:fragment slot="header">
        <div class="bg-surface-100-800-token">
            <div class="container">
                <AppBar background="bg-transparent">
                    <svelte:fragment slot="lead">
                        <a href="/" use:inertia>
                            <strong class="text-xl uppercase">{$page.props.siteName}</strong>
                        </a>
                    </svelte:fragment>

                    <svelte:fragment slot="trail">
                        <LightSwitch />

                        {#if auth}
                            <a class="btn btn-sm variant-ghost-surface" href="/dashboard" use:inertia> Dashboard </a>
                            <form on:submit|preventDefault={handleLogout}>
                                <button type="submit" class="btn btn-sm variant-ghost-surface"> Logout </button>
                            </form>
                        {:else}
                            <a class="btn btn-sm variant-ghost-surface" href={route('login')} use:inertia> Login </a>
                            <a class="btn btn-sm variant-ghost-surface" href={route('register')} use:inertia>
                                Register
                            </a>
                        {/if}

                        <a
                            class="btn btn-sm variant-ringed-surface"
                            href="https://twitter.com/acelords"
                            target="_blank"
                            rel="noreferrer"
                        >
                            Twitter
                        </a>
                        <a
                            class="btn btn-sm variant-ringed-surface"
                            href="https://github.com/lexxyungcarter/laravelte"
                            target="_blank"
                            rel="noreferrer"
                        >
                            GitHub
                        </a>
                    </svelte:fragment>

                    <div class="hidden lg:flex gap-5 justify-center">
                        <a class="nav-item-link" href={route('about')} use:inertia> About </a>
                        <a class="nav-item-link" href={route('contact')} use:inertia> Contact </a>
                    </div>
                </AppBar>
            </div>
        </div>
    </svelte:fragment>

    <!-- content -->
    <slot />

    <svelte:fragment slot="footer">
        <!-- footer -->
        <div class="bg-surface rounded-lg shadow dark:bg-surface-900 m-4">
            <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
                <div class="sm:flex sm:items-center sm:justify-between">
                    <a href="/" use:inertia class="mb-4 sm:mb-0">
                        <img src="/img/laravelte-logo-full.png" class="h-8 mr-3" alt="logo" />
                        <br />
                        <div class="text-2xl font-semibold whitespace-nowrap dark:text-white">
                            {$page.props.siteName}
                        </div>
                    </a>
                    <ul
                        class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400"
                    >
                        <li>
                            <a href={route('about')} class="mr-4 hover:underline md:mr-6" use:inertia>About</a>
                        </li>

                        <li>
                            <a href={route('contact')} class="mr-4 hover:underline md:mr-6" use:inertia>Contact</a>
                        </li>
                        <li>
                            <a href={route('policy-pages', 'privacy-policy')} class="mr-4 hover:underline md:mr-6"
                                >Privacy Policy</a
                            >
                        </li>
                        <li>
                            <a href="https://ko-fi.com/acelords" target="_blank" class="mr-4 hover:underline md:mr-6"
                                >Support Development</a
                            >
                        </li>
                    </ul>
                </div>
                <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400"
                    >© 2023 <a href="https://flowbite.com/" class="hover:underline">Flowbite™</a>. All Rights Reserved.</span
                >
            </div>
        </div>
    </svelte:fragment>
</MainLayout>

<style lang="css">
    .nav-item-link {
        @apply hover:underline hover:underline-offset-8;
    }
</style>
