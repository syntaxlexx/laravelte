<script lang="ts">
    import { Icon, ThemeSwitcher } from '@/Components'
    import { inertia, page, useForm } from '@inertiajs/svelte'
    import { createEventDispatcher } from 'svelte'
    import type { User } from '@/types'

    const dispatch = createEventDispatcher()

    function handleClick() {
        dispatch('click')
    }

    $: auth = $page.props.auth?.user as User

    let form = useForm()

    function handleLogout(e: MouseEvent) {
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
            route: route('admin.dashboard'),
            icon: 'home',
        },
        {
            title: 'Configurations',
            route: route('admin.settings.configurations'),
            icon: 'cog',
        },
        {
            title: ' My Profile',
            route: route('admin.profile'),
            icon: 'user',
        },
    ]

    const quickLinks: NavItem[] = [
        {
            title: 'Reset System',
            route: route('admin.settings.reset-system'),
            icon: 'bug',
        },
        {
            title: 'Go to Frontend',
            route: '/',
            icon: 'arrow-back',
        },
    ]
</script>

<nav class="lg:flex-1 px-2 lg:py-4">
    <div class="space-y-1">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->

        {#each navItems as item}
            <a
                class="nav-item group"
                class:active={item.route.endsWith($page.url)}
                href={item.route}
                use:inertia
                on:click={handleClick}
            >
                <Icon name={item.icon} classes="text-gray-300 mr-3" />
                {item.title}
            </a>
        {/each}
    </div>

    <div class="mt-10">
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Quick Links</p>
        <div class="mt-2 space-y-1">
            {#each quickLinks as item}
                <a href={item.route} class="group quick-link" use:inertia on:click={handleClick}>
                    <Icon name={item.icon} classes="text-gray-300 mr-3" />

                    <span class="truncate"> {item.title} </span>
                </a>
            {/each}

            <a href="#" class="group quick-link" on:click|preventDefault={handleLogout}>
                <Icon name="exit" classes="text-gray-300 mr-3" />
                Logout</a
            >
            <div class="quick-item ml-3 flex items-center pt-3">
                <span class="text-sm font-medium text-gray-300 mr-3">Toggle Theme</span>
                <ThemeSwitcher />
            </div>
        </div>
    </div>
</nav>

<style lang="css">
    .nav-item {
        @apply no-underline text-gray-300 hover:bg-gray-700 hover:text-white  flex items-center px-2 py-2 text-sm font-medium rounded-md;
    }
    .nav-item.active {
        @apply bg-gray-900 text-white  flex items-center px-2 py-2 text-sm font-medium rounded-md;
    }
    .quick-link {
        @apply no-underline flex items-center px-3 py-2 text-sm font-medium text-gray-300 rounded-md hover:text-white hover:bg-gray-700;
    }
</style>
