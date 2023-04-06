<script lang="ts">
    import Title from '@/Components/Title.svelte'
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="container mt-5" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Title>About Us Page</Title>
    <a href="/" use:inertia>Go Home</a>
    <br />
    <a href={route('contact')} use:inertia>Contact</a>
</div>
