<script>
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="container mt-5">
    {#if ready}
        <div in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <h2>Admin Dashboard</h2>
            <a href="/" use:inertia>Go Home</a>
        </div>
    {/if}
</div>
