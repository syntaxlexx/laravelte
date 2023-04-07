<script lang="ts">
    import Circle from '@/Components/Circle.svelte'
    import SimpleTable from '@/Components/SimpleTable.svelte'
    import Title from '@/Components/Title.svelte'
    import { snakeCaseToSentenceCaseCapitalizeWords } from '@/helpers'
    import type { SystemConfiguration } from '@/types'
    import { modalStore } from '@skeletonlabs/skeleton'
    import type { ModalSettings, ModalComponent } from '@skeletonlabs/skeleton'
    import ConfigurationModal from './ConfigurationModal.svelte'

    export let configurations: SystemConfiguration[]
    let search: string | undefined

    $: filteredList = configurations.filter(it => {
        if (search) {
            return it.name.toLowerCase().includes(search.toLowerCase())
        }
        return it
    })

    const headers = ['#', 'Name', 'Value', 'Action']

    function editItem(item: SystemConfiguration) {
        console.log('item', item)

        const modalComponent: ModalComponent = {
            // Pass a reference to your custom component
            ref: ConfigurationModal,
            // Add the component properties as key/value pairs
            props: { configuration: item, title: 'Update Configuration' },
            // Provide a template literal for the default component slot
            slot: '<p>Modal</p>',
        }

        const d: ModalSettings = {
            type: 'component',
            // Pass the component registry key as a string:
            component: modalComponent,
        }
        modalStore.trigger(d)
    }

    function handleSearch(e: CustomEvent) {
        search = e.detail
    }
</script>

<div class="container mt-5">
    <Title>Configurations</Title>
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
