<script lang="ts">
    import { Button } from '@/Components'
    import { formatDateTime } from '@/helpers'
    import type { ContactMessage } from '@/types'
    import { closeModal } from 'svelte-modals'

    export let isOpen: boolean
    export let message: ContactMessage
    export let title: string
</script>

{#if isOpen}
    <div role="dialog" class="modal">
        <div class="modal-content-container">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">{title}</div>
                </div>
                <div class="modal-body">
                    <div class="flex flex-wrap justify-between items-center">
                        <a href="mailto:{message.email}">{message.email ?? ''}</a>
                        <a href="tel:{message.phone}">{message.phone ?? ''}</a>
                        <div>Last read: {formatDateTime(message.last_read_at_w3c)}</div>
                    </div>
                    <br />
                    <h5>{message.subject}</h5>
                    <div>{message.body}</div>
                </div>
                <footer class="modal-footer">
                    <Button color="ghost" type="button" on:click={closeModal}>Close</Button>
                </footer>
            </div>
        </div>
    </div>
{/if}
