<script>
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import ContactMessages from './Components/ContactMessages.svelte'
    import AdminTitle from './Components/AdminTitle.svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="">
    {#if ready}
        <div in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <br />
            <AdminTitle>Admin Dashboard</AdminTitle>
            <ContactMessages />
        </div>
    {/if}
</div>
