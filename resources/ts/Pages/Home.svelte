<script lang="ts">
    import { page } from '@inertiajs/svelte'
    import { fly, fade } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'

    let ready = false
    onMount(() => (ready = true))

    export let laravelVersion: string
    export let phpVersion: string
</script>

<svelte:head>
    <title>Welcome</title>
</svelte:head>

<div class="container page-padding mx-auto flex justify-center items-center">
    <div class="space-y-10 text-center">
        {#if ready}
            <div class="flex gap-2 items-center justify-center" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
                <h2>
                    <span
                        class="bg-gradient-to-br from-red-500 to-yellow-500 bg-clip-text text-transparent box-decoration-clone"
                        >Welcome</span
                    >
                </h2>
                <h2>to</h2>
                <h2>
                    <span
                        class="bg-gradient-to-br from-pink-500 to-violet-500 bg-clip-text text-transparent box-decoration-clone"
                    >
                        {$page.props.siteName}.
                    </span>
                </h2>
            </div>
        {/if}

        {#if ready}
            <figure class="max-w-[80%]" in:fly={{ y: 70, duration: 300, delay: 300, easing: quintOut }}>
                <section class="img-bg" />
                <img src="/img/laravelte-logo.png" alt="logo" class="h-12 md:h-16 lg:h-24 w-auto" />
            </figure>
        {/if}

        {#if ready}
            <div class="text-center" in:fade={{ delay: 700, duration: 700, easing: quintOut }}>
                <a class="btn btn-filled" href="https://skeleton.dev/" target="_blank" rel="noreferrer">
                    Powered by<strong class="ml-1 underline">Skeleton UI (TailwindCSS)</strong>
                </a>
                <br />
                <a class="btn btn-filled" href="https://flowbite.com/docs/" target="_blank" rel="noreferrer">
                    ... and some bit of<strong class="ml-1 underline">Flowbite (TailwindCSS)</strong>
                </a>
            </div>
        {/if}

        {#if ready}
            <div class="space-y-2 flex justify-center" in:fly={{ y: 50, delay: 1200, duration: 500, easing: quintOut }}>
                <div class="flex flex-col md:flex-wrap lg:flex-row gap-2">
                    <p>Laravel Version: {laravelVersion}</p>
                    <span class="hidden lg:block">&middot;</span>
                    <p>PHP Version: {phpVersion}</p>
                </div>
            </div>
        {/if}
    </div>
</div>

<style lang="postcss">
    figure {
        @apply flex relative flex-col;
    }
    .img-bg {
        @apply h-12 md:h-16 lg:h-24 w-full;
    }
    .img-bg {
        @apply absolute z-[-1] rounded-full blur-[50px] transition-all;
        animation: pulse 5s cubic-bezier(0, 0, 0, 0.5) infinite, glow 5s linear infinite;
    }
    @keyframes glow {
        0% {
            @apply bg-primary-400/50;
        }
        33% {
            @apply bg-secondary-400/50;
        }
        66% {
            @apply bg-tertiary-400/50;
        }
        100% {
            @apply bg-primary-400/50;
        }
    }
    @keyframes pulse {
        50% {
            transform: scale(1.5);
        }
    }
</style>
