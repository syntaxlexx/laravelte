<script lang="ts">
    import { createEventDispatcher } from 'svelte'
    import { Icon, Loading } from '.'
    import { slide } from 'svelte/transition'
    import { quadOut } from 'svelte/easing'
    import { router } from '@inertiajs/svelte'

    const dispatch = createEventDispatcher<{ click: void }>()

    type ButtonSize = 'normal' | 'sm' | 'lg'
    type ButtonColor = 'primary' | 'secondary' | 'tertiary' | 'danger' | 'ghost' | 'light'

    export let size: ButtonSize = 'normal'
    export let color: ButtonColor = 'primary'
    export let block: string | boolean | undefined = undefined
    export let loading: boolean = false
    export let icon: string | undefined = undefined
    export let text: string | undefined = 'Click me'

    export let route: string | undefined = undefined

    function handleClick() {
        if (route !== undefined) {
            router.visit(route)
            return
        }
        dispatch('click')
    }
</script>

<button
    class={`py-2 lg:py-3 px-4 lg:px-5 mx-1 flex gap-2 justify-center items-center text-sm lg:text-md ${color} btn-${size} ${
        block !== undefined ? 'w-full' : ''
    }`}
    {...$$restProps}
    on:click={handleClick}
>
    {#if icon}
        <Icon name={icon} size="lg" />
    {/if}

    <slot>
        {text}
    </slot>

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
    button.danger {
        @apply border border-red-500 dark:border-red-500 shadow-sm font-medium rounded-md text-white dark:text-red-100 bg-red-500 dark:bg-red-800 hover:bg-red-900 dark:hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500;
    }
    button.ghost {
        @apply border border-primary-700 dark:border-primary-300 text-primary-800 dark:text-primary-200 hover:bg-primary-100 dark:hover:bg-primary-700;
    }
    button.light {
        @apply border border-gray-300 dark:border-gray-600 shadow-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500;
    }
    button.btn-sm {
        @apply py-1 lg:py-2 px-2 lg:px-3;
    }
    button.btn-lg {
        @apply py-2.5 lg:py-3 px-3 lg:px-5;
    }
</style>
