<script lang="ts">
    import { drawerStore } from '@skeletonlabs/skeleton'
    import { inertia } from '@inertiajs/svelte'

    function drawerClose(): void {
        drawerStore.close()
    }
</script>

<nav class="list-nav">
    <ul>
        <li><a href={route('admin.dashboard')} use:inertia on:click={drawerClose}>Dashboard</a></li>
        <li><a href={route('admin.settings.configurations')} use:inertia on:click={drawerClose}>Configurations</a></li>
        <li><a href={route('admin.settings.reset-system')} use:inertia on:click={drawerClose}>Reset System</a></li>
    </ul>
</nav>
