<script lang="ts">
    import type { ContactMessage, PaginationMeta, TableHeader } from '@/types'
    import axios from 'axios'
    import { openModal } from 'svelte-modals'
    import ContactMessagesModal from './ContactMessagesModal.svelte'
    import { Circle, SimpleTable } from '@/Components'
    import { confirmAction } from '@/helpers'
    import { toasts } from 'svelte-toasts'

    let messages: ContactMessage[] = []
    let meta: PaginationMeta
    let headers: string[] | TableHeader[] = []
    let page = 1

    async function fetch() {
        const resp = await axios.get(route('admin.cms.contact-messages'), {
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
            },
        })

        messages = resp.data.data
        meta = resp.data.meta
        headers = resp.data.headers
    }

    fetch()

    function viewItem(item: ContactMessage) {
        openModal(ContactMessagesModal, { message: item, title: item.name })
    }

    function deleteItem(item: ContactMessage) {
        confirmAction('Are you sure you want to delete the item?', () => {
            axios
                .delete(route('admin.cms.contact-messages.destroy', item.id), {
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                })
                .then(resp => {
                    toasts.success('Deleted')

                    fetch()
                })
        })
    }
</script>

<h4 class="mb-4">Contact Messages</h4>
<div class="card p-4">
    {#if messages.length > 0}
        <SimpleTable {headers} hasFooter>
            {#each messages as item}
                <tr class="cursor-pointer">
                    <td on:click={() => viewItem(item)}>#{item.id}</td>
                    <td on:click={() => viewItem(item)}>{item.name}</td>
                    <td on:click={() => viewItem(item)}>
                        <div class="text-sm">{item.phone}</div>
                        <div class="text-xs">{item.email}</div>
                    </td>
                    <td on:click={() => viewItem(item)}>
                        <div class="w-40 truncate">
                            {item.body}
                        </div>
                    </td>
                    <td>
                        <Circle size="n" icon="delete" on:click={() => deleteItem(item)} />
                    </td>
                </tr>
            {/each}
        </SimpleTable>
    {:else}
        <p class="text-center">No messages found</p>
    {/if}
</div>
