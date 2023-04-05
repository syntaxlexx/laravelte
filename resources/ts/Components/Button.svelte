<script lang="ts">
    import { ProgressRadial } from '@skeletonlabs/skeleton'
    import { quintOut } from 'svelte/easing'
    import { slide } from 'svelte/transition'
    import { createEventDispatcher } from 'svelte'

    const dispatch = createEventDispatcher()

    function handleClick() {
        dispatch('click')
    }

    type ButtonColor = 'primary' | 'secondary' | 'tertiary' | 'ghost'

    export let loading = false

    export let color: ButtonColor = 'primary'

    $: bg =
        color === 'primary'
            ? 'variant-filled'
            : color === 'ghost'
            ? 'variant-ghost-primary'
            : color === 'secondary'
            ? 'variant-ringed-primary'
            : `variant-filled-${color}`
</script>

<button class="btn {bg}" {...$$props} disabled={loading} on:click={handleClick}>
    <slot />
    {#if loading}
        <div class="ml-4" transition:slide={{ duration: 500, easing: quintOut, axis: 'x' }}>
            <ProgressRadial stroke={100} width="w-6" meter="stroke-primary-500" track="stroke-primary-500/20" />
        </div>
    {/if}
</button>
