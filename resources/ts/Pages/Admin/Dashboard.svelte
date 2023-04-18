<script>
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import ContactMessages from './Components/ContactMessages.svelte'
    import AdminTitle from './Components/AdminTitle.svelte'
    import AdminStats from './Components/AdminStats.svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="">
    {#if ready}
        <div in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <AdminTitle>Admin Dashboard</AdminTitle>
            <AdminStats />
            <br />
            <ContactMessages />
        </div>
    {/if}
</div>
