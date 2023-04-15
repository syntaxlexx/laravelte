<script lang="ts">
    import { page } from '@inertiajs/svelte'
    import { fly, fade } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import Hero from '@/Components/Hero.svelte'

    let ready = false
    onMount(() => (ready = true))

    export let laravelVersion: string
    export let phpVersion: string
</script>

<svelte:head>
    <title>Welcome</title>
</svelte:head>

<div class="mt-16" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Hero />

    <div class="container page-padding">
        <p>Laravel: {laravelVersion}</p>
        <p>PHP: {phpVersion}</p>
    </div>
</div>
