<script>
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import UserTitle from './Components/UserTitle.svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="">
    {#if ready}
        <div in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <UserTitle>User Dashboard</UserTitle>
        </div>
    {/if}
</div>
