<script lang="ts">
    import { createEventDispatcher } from 'svelte'
    import { Input } from '.'
    import type { TableHeader } from '@/types'

    const dispatch = createEventDispatcher()

    export let hasBorder: boolean | undefined = undefined
    export let hasSearch: boolean | undefined = undefined
    export let hasFooter: boolean | undefined = undefined
    export let headers: string[] | TableHeader[] = []
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
                    <Input
                        type="text"
                        name="search"
                        {placeholder}
                        noMb
                        bind:value={term}
                        on:input={handleChange}
                        style={`max-width: ${maxWidth}px; min-width: 300px;`}
                    />
                </div>
            </slot>
        </div>
    {/if}

    <div class="table-responsive">
        <table class="table">
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
                            <div class="text-lg">{emptyText}</div>
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
