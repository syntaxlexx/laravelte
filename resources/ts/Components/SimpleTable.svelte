<script lang="ts">
    import Empty from '@/Components/Empty.svelte'
    import { createEventDispatcher } from 'svelte'

    const dispatch = createEventDispatcher()

    type ObjectHeader = {
        text: string
        align: 'left' | 'right' | 'center'
    }

    export let hasBorder: boolean | undefined = undefined
    export let hasSearch: boolean | undefined = undefined
    export let hasFooter: boolean | undefined = undefined
    export let headers: string[] | ObjectHeader[] = []
    export let emptyText: string = 'No data found'

    export let placeholder: string = 'Search'
    export let maxWidth = 300
    let term: string = ''

    $: hasHeader = headers.length > 0

    function handleChange() {
        dispatch('search', term)
    }
</script>

<div
    class="simple-table {hasBorder !== undefined
        ? 'border-2 border-solid border-primary-200 dark:border-primary-600 rounded'
        : ''}"
>
    {#if hasSearch}
        <div class="flex flex-wrap justify-between items-center mb-2">
            <div>
                <slot name="title">
                    <div class="m-2">
                        <!-- <Title v-if="title">{{ title }}</Title>
                <p v-if="subtitle">{{ subtitle }}</p> -->
                    </div>
                </slot>
                <div class="ml-2 flex gap-2">
                    <slot name="buttons" class="ms-2" />
                </div>
            </div>
            <slot name="search">
                <div class="m-2">
                    <input
                        class="input"
                        type="text"
                        name="search"
                        {placeholder}
                        bind:value={term}
                        on:input={handleChange}
                        style={`max-width: ${maxWidth}px; min-width: 300px;`}
                    />
                </div>
            </slot>
        </div>
    {/if}

    <div class="table-responsive">
        <table class="table text-token">
            {#if hasHeader}
                <thead class="table-head">
                    <tr>
                        {#each headers as header}
                            <th>
                                {#if typeof header === 'object'}
                                    <span style="text-align: {header.align}">
                                        {header.text}
                                    </span>
                                {:else}
                                    {header}
                                {/if}
                            </th>
                        {/each}
                    </tr>
                </thead>
            {/if}
            <tbody class="table-body">
                <slot>
                    <td colspan={headers.length}>
                        <div class="mx-auto">
                            <Empty>{emptyText}</Empty>
                        </div>
                    </td>
                </slot>
            </tbody>
            {#if hasFooter}
                <tfoot class="table-foot">
                    <slot name="footer">
                        <tr>
                            {#each headers as header}
                                <th>
                                    {#if typeof header === 'object'}
                                        <span sytle="text-align: {header.align}">
                                            {header.text}
                                        </span>
                                    {:else}
                                        {header}
                                    {/if}
                                </th>
                            {/each}
                        </tr>
                    </slot>
                </tfoot>
            {/if}
        </table>
    </div>
</div>

<style lang="css">
    /* .table-responsive {
        @apply overflow-x-auto relative shadow-md sm:rounded-lg;
    }
    table {
        @apply w-full text-sm text-left text-gray-500 dark:text-gray-400;
    }
    table caption {
        @apply p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800;
    }

    table caption p {
        @apply mt-1 text-sm font-normal text-gray-500 dark:text-gray-400;
    }

    table thead,
    table tfoot {
        @apply text-xs text-gray-700 uppercase bg-gray-50 dark:bg-[#2c3543] dark:text-gray-400;
    }

    table thead tr td,
    table thead tr th,
    table tfoot tr td,
    table tfoot tr th {
        @apply py-3 px-6;
    }
    table tbody tr {
        @apply bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700;
    }
    table tbody tr th {
        @apply py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white;
    }
    table tbody tr td {
        @apply py-4 px-6;
    }
    table .actions {
        @apply flex gap-2;
    } */
</style>
