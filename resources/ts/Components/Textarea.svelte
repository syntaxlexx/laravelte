<script lang="ts">
    import { createEventDispatcher } from 'svelte'

    export let label: string | undefined = undefined
    export let placeholder: string = 'Start typing ...'
    export let name: string
    export let rows: number = 4
    export let id: string = 'message'

    let value = ''

    const dispatch = createEventDispatcher()
    function handleInput() {
        dispatch('input', value)
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
        class="bg-primary-50 dark:bg-primary-800 border border-primary-300 dark:border-primary-500 text-primary-900 dark:text-primary-100 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 focus:outline-primary-500 placeholder:text-gray-400 dark:placeholder:text-primary-600"
        {placeholder}
        bind:value
        on:input={handleInput}
        {...$$props}
    />
</div>
