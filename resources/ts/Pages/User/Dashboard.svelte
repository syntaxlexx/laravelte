<script>
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { Title } from '@/Components'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="container mt-5">
    {#if ready}
        <div in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <Title>User Dashboard</Title>
        </div>
    {/if}
</div>
