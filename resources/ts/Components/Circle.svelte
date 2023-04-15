<script lang="ts">
    import Icon from './Icon.svelte'
    import { createEventDispatcher } from 'svelte'

    const dispatch = createEventDispatcher()

    function handleClick() {
        dispatch('click')
    }

    type CircleSize = 'sm' | 'lg' | 'xl' | 'n'
    type CircleColor = 'primary' | 'danger' | 'success' | 'error' | 'warning'

    export let icon = 'edit'
    export let size: CircleSize = 'sm'
    export let color: CircleColor = 'primary'
</script>

<button
    type="button"
    class="circle-{size} rounded-full circle-{color} text-white flex flex-col items-center justify-center"
    on:click={handleClick}
    {...$$props}
>
    <Icon name={icon} />
</button>

<style lang="css">
    button.circle-primary {
        @apply bg-primary-500 hover:bg-primary-600 focus:bg-primary-700;
    }
    button.circle-success {
        @apply bg-green-500 hover:bg-green-600 focus:bg-green-700;
    }
    button.circle-warning {
        @apply bg-yellow-500 hover:bg-yellow-600 focus:bg-yellow-700;
    }
    button.circle-error,
    button.circle-danger {
        @apply bg-red-500 hover:bg-red-600 focus:bg-red-700;
    }
    button.circle-xl {
        @apply w-12 h-12 text-3xl;
    }
    button.circle-lg {
        @apply w-10 h-10 text-2xl;
    }
    button.circle-sm {
        @apply w-6 h-6 text-base;
    }
    button.circle-n {
        @apply w-8 h-8 text-xl;
    }
</style>
