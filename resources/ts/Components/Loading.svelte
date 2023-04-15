<script lang="ts">
    import { Wave, Moon } from 'svelte-loading-spinners'

    type LoadingType = 'moon' | 'wave'

    export let size = 30
    export let color = '#b874f8'
    export let duration = '1s'
    export let unit = 'px'
    export let type: LoadingType = 'moon'
</script>

{#if type == 'moon'}
    <Moon {size} {color} {unit} {duration} />
{:else if type == 'wave'}
    <Wave {size} {color} {unit} {duration} />
{/if}
