<script lang="ts">
    import { page } from '@inertiajs/svelte'
    import { fly, fade } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import Hero from '@/Components/Hero.svelte'
    import PremiumAccess from '@/Components/PremiumAccess.svelte'
    import Sweet from '@/Components/Sweet.svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<svelte:head>
    <title>Welcome</title>
</svelte:head>

<div class="mt-16" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Hero />

    <br />

    <PremiumAccess />
    <Sweet />
</div>
