<script lang="ts">
    import Icon from './Icon.svelte'
    import { createEventDispatcher } from 'svelte'

    const dispatch = createEventDispatcher()

    function handleClick() {
        dispatch('click')
    }

    type CircleSize = 'sm' | 'lg' | 'xl' | 'n'

    export let icon = 'edit'
    export let size: CircleSize = 'sm'

    $: btnSize = size == 'n' ? '' : `btn-icon-${size}`
</script>

<button type="button" class="btn-icon variant-filled {btnSize}" on:click={handleClick} {...$$props}>
    <Icon name={icon} />
</button>
