<script lang="ts">
    import { quadOut } from 'svelte/easing'
    import { slide } from 'svelte/transition'

    export let errors: Map<string, any> | null = null

    $: hasErrors = errors && Object.keys(errors).length > 0
</script>

{#if hasErrors}
    <div class="card p-4 bg-error-active-token" in:slide={{ axis: 'y', duration: 300, easing: quadOut }}>
        {#each Object.values(errors) as err}
            <div class="text-sm">{err}</div>
        {/each}
    </div>
{/if}
