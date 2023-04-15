<script lang="ts">
    import { createEventDispatcher } from 'svelte'
    import { Loading } from '.'
    import { slide } from 'svelte/transition'
    import { quadOut } from 'svelte/easing'
    const dispatch = createEventDispatcher()

    type ButtonSize = 'normal' | 'sm' | 'lg'
    type ButtonColor = 'primary' | 'secondary' | 'tertiary' | 'ghost'

    export let size: ButtonSize = 'normal'
    export let color: ButtonColor = 'primary'
    export let block: string | boolean | undefined = undefined
    export let loading: boolean = false
</script>

<button
    class={`py-2 lg:py-3 px-4 lg:px-5 mx-1 flex gap-4 justify-center items-center text-sm lg:text-md ${color} btn-${size} ${
        block !== undefined ? 'w-full' : ''
    }`}
    {...$$restProps}
    on:click={() => dispatch('click')}
>
    <slot />

    {#if loading}
        <div transition:slide={{ axis: 'x', duration: 300, easing: quadOut }}>
            <Loading color="#fff" size={20} />
        </div>
    {/if}

    <slot name="suffix" />
</button>

<style lang="css">
    button {
        /* margin: 10px; */
        text-align: center;
        text-transform: uppercase;
        transition: 0.5s;
        background-size: 200% auto;
        color: #fff;
        border-radius: 10px;
    }
    button.primary {
        @apply bg-gradient-to-r from-primary-700 via-primary-800 to-primary-900;
    }
    button.red {
        @apply bg-gradient-to-r from-red-600 via-red-700 to-red-800;
    }
    button.secondary {
        @apply bg-gradient-to-r from-secondary-500 via-secondary-600 to-secondary-700 hover:opacity-70;
    }
    button.tertiary {
        @apply bg-gradient-to-r from-tertiary-500 via-tertiary-600 to-tertiary-700 hover:opacity-70;
    }
    button.ghost {
        @apply border border-primary-700 dark:border-primary-300 text-primary-800 dark:text-primary-200;
    }
    button.btn-sm {
        @apply py-1 lg:py-2 px-2 lg:px-3;
    }
</style>
