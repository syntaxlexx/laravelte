<script lang="ts">
    import Circle from '@/Components/Circle.svelte'
    import SimpleTable from '@/Components/SimpleTable.svelte'
    import type { ContactMessage, PaginationMeta } from '@/types'
    import axios from 'axios'
    import { modalStore, toastStore } from '@skeletonlabs/skeleton'
    import type { ModalSettings, ModalComponent, ToastSettings } from '@skeletonlabs/skeleton'
    import ContactMessagesModal from './ContactMessagesModal.svelte'

    let messages: ContactMessage[] = []
    let meta: PaginationMeta
    let headers = []
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
        const modalComponent: ModalComponent = {
            ref: ContactMessagesModal,
            props: { message: item, title: item.name },
            slot: '<p>Modal</p>',
        }

        const d: ModalSettings = {
            type: 'component',
            component: modalComponent,
        }
        modalStore.trigger(d)
    }

    function deleteItem(item: ContactMessage) {
        const confirm: ModalSettings = {
            type: 'confirm',
            title: 'Delete?',
            body: 'Are you sure you want to delete the item?',
            response: (r: boolean) => {
                if (r) {
                    axios
                        .delete(route('admin.cms.contact-messages.destroy', item.id), {
                            headers: {
                                Accept: 'application/json',
                                'Content-Type': 'application/json',
                            },
                        })
                        .then(resp => {
                            const t: ToastSettings = {
                                message: 'Deleted',
                                background: 'variant-filled-success',
                            }
                            toastStore.trigger(t)
                            fetch()
                        })
                }
            },
        }

        modalStore.trigger(confirm)
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
                        <Circle icon="delete" size="sm" on:click={() => deleteItem(item)} />
                    </td>
                </tr>
            {/each}
        </SimpleTable>
    {:else}
        <p class="text-center">No messages found</p>
    {/if}
</div>
