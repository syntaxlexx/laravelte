<script lang="ts">
    import { createEventDispatcher } from 'svelte'

    export let label: string | undefined = undefined
    export let placeholder: string = 'Start typing ...'
    export let name: string
    export let rows: number = 4
    export let id: string = 'message'
    export let value: string | null = null

    type InputColor = 'primary' | 'default'
    export let color: InputColor = 'primary'

    const dispatchKeydown = createEventDispatcher<{ keydown: KeyboardEvent }>()
    function handleKeydown(e: KeyboardEvent) {
        dispatchKeydown('keydown', e)
    }
</script>

<div>
    {#if label}
        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{label}</label>
    {/if}

    <textarea
        {name}
        id={name ?? id}
        {rows}
        class="border text-sm rounded-lg block w-full p-2.5 textarea-{color}"
        {placeholder}
        bind:value
        on:keydown={handleKeydown}
        {...$$props}
    />
</div>

<style lang="css">
    .textarea-primary {
        @apply bg-primary-50 dark:bg-primary-800 border-primary-300 dark:border-primary-500 text-primary-900 dark:text-primary-100 focus:ring-primary-500 focus:border-primary-500 focus:outline-primary-500 placeholder:text-gray-400 dark:placeholder:text-primary-600;
    }
    .textarea-default {
        @apply bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-900 dark:text-gray-100 focus:ring-gray-300 dark:focus:ring-gray-500 focus:border-gray-300 dark:focus:border-gray-600 focus:outline-gray-300 dark:focus:outline-gray-500 placeholder:text-gray-300 dark:placeholder:text-gray-600;
    }
</style>
