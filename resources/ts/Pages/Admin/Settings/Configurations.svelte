<script lang="ts">
    import Circle from '@/Components/Circle.svelte'
    import SimpleTable from '@/Components/SimpleTable.svelte'
    import { snakeCaseToSentenceCaseCapitalizeWords } from '@/helpers'
    import type { SystemConfiguration } from '@/types'

    export let configurations: SystemConfiguration[]
    let search: string | undefined

    $: filteredList = configurations.filter(it => {
        if (search) {
            return it.name.toLowerCase().includes(search)
        }
        return it
    })

    const headers = ['#', 'Name', 'Value', 'Action']

    function editItem(item: SystemConfiguration) {
        console.log('item', item)
    }

    function handleSearch(e: CustomEvent) {
        search = e.detail
    }
</script>

<div class="container mt-5">
    <h2>Configurations</h2>
    <br />
    <SimpleTable {headers} hasFooter hasSearch on:search={handleSearch}>
        {#each filteredList as item, i}
            <tr>
                <td title={item.id.toString()}>{i + 1}</td>
                <td
                    >{snakeCaseToSentenceCaseCapitalizeWords(item.name)}
                    <div class="text-xs">{item.description}</div>
                </td>
                <td>
                    {#if item.type == 'bool'}
                        {item.value == 1 ? 'YES/TRUE' : 'NO/FALSE'}
                    {:else}
                        {item.value}
                    {/if}
                </td>
                <td>
                    <Circle icon="edit" on:click={() => editItem(item)} />
                </td>
            </tr>
        {/each}
    </SimpleTable>
</div>
