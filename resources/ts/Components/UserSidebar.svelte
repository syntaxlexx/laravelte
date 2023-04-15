<script lang="ts">
    import { inertia, page, useForm } from '@inertiajs/svelte'
    import { onMount } from 'svelte'
    import { Icon, Input } from '.'

    $: auth = $page.props.auth?.user

    let form = useForm()

    function handleLogout(e) {
        e.preventDefault()

        $form.post(route('logout'))
    }

    type NavItem = {
        title: string
        route: string
        icon: string
    }

    const navItems: NavItem[] = [
        {
            title: 'Dashboard',
            route: route('user.dashboard'),
            icon: 'home',
        },
        {
            title: ' My Profile',
            route: route('user.profile'),
            icon: 'user',
        },
        {
            title: 'Go Home',
            route: '/',
            icon: 'arrow-back',
        },
    ]

    function drawerClose(): void {
        // drawerStore.close()
    }
</script>

<div class="">
    <!-- <img src={$page.props.siteLogo} alt={$page.props.siteName} /> -->
    <h3 class="text-2xl font-normal underline underline-offset-8">{$page.props.siteName}</h3>
    <br />
    <div class="flex gap-5 items-center">
        <img src={auth.avatar_url} alt="avatar" class="bg-gray-200 rounded-full w-14 h-14" />
        <div class="flex-1">
            <h4 class="font-semibold text-xl text-gray-800 dark:text-gray-200">{auth.full_name}</h4>
            <p class="text-gray-500">@{auth.name}</p>
        </div>
    </div>
    <br />
    <Input name="search" placeholder="Search" prefixIcon="search" color="default" />
</div>

<nav class="overflow-y-auto">
    <ul>
        {#each navItems as item}
            <li>
                <a
                    class="nav-item"
                    class:bg-primary-active-token={item.route.endsWith($page.url)}
                    href={item.route}
                    use:inertia
                    on:click={drawerClose}
                >
                    <Icon name={item.icon} classes="text-xl text-gray-600 dark:text-gray-400" />
                    {item.title}
                </a>
            </li>
        {/each}
    </ul>
    <br />
    <ul>
        <li>
            <a href=":;" class="nav-item" on:click|preventDefault={handleLogout}>
                <Icon name="exit" classes="text-xl text-gray-600 dark:text-gray-400" />
                Logout</a
            >
        </li>
    </ul>
</nav>

<style lang="css">
    .nav-item {
        @apply no-underline hover:no-underline px-3 py-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 flex gap-2 items-center text-gray-900 dark:text-gray-200 text-lg;
    }
</style>
