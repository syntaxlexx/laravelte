<script lang="ts">
    import { drawerStore } from '@skeletonlabs/skeleton'
    import { inertia } from '@inertiajs/svelte'

    type NavItem = {
        title: string
        route: string
    }

    const navItems: NavItem[] = [
        {
            title: 'Dashboard',
            route: route('admin.dashboard'),
        },
        {
            title: 'Configurations',
            route: route('admin.settings.configurations'),
        },
        {
            title: 'Reset System',
            route: route('admin.settings.reset-system'),
        },
    ]

    function drawerClose(): void {
        drawerStore.close()
    }
</script>

<nav class="list-nav">
    <ul>
        {#each navItems as item}
            <li><a href={item.route} use:inertia on:click={drawerClose}>{item.title}</a></li>
        {/each}
    </ul>
</nav>
