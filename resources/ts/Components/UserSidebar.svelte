<script lang="ts">
    import { drawerStore } from '@skeletonlabs/skeleton'
    import { inertia, page } from '@inertiajs/svelte'

    type NavItem = {
        title: string
        route: string
    }

    const navItems: NavItem[] = [
        {
            title: 'Dashboard',
            route: route('user.dashboard'),
        },
        {
            title: ' My Profile',
            route: route('user.dashboard'),
        },
        {
            title: 'Go Home',
            route: '/',
        },
    ]

    function drawerClose(): void {
        drawerStore.close()
    }
</script>

<nav class="list-nav">
    <ul>
        {#each navItems as item}
            <li>
                <a
                    class="!rounded hover:rounded focus:rounded"
                    class:bg-primary-active-token={item.route.endsWith($page.url)}
                    href={item.route}
                    use:inertia
                    on:click={drawerClose}
                    >{item.title}
                </a>
            </li>
        {/each}
    </ul>
</nav>
