<script lang="ts">
    import { formatDateTime } from '@/helpers'
    import type { ContactMessage } from '@/types'

    export let parent: any
    export let message: ContactMessage
    export let title: string

    // Base Classes
    const cBase = 'card p-4 w-modal shadow-xl space-y-4'
    const cHeader = 'text-2xl font-bold'
    const cForm = 'border border-surface-500 p-4 space-y-4 rounded-container-token'
</script>

<div class={cBase}>
    <header class={cHeader}>{title}</header>
    <div class="flex flex-wrap justify-between items-center">
        <a href="mailto:{message.email}">{message.email ?? ''}</a>
        <a href="tel:{message.phone}">{message.phone ?? ''}</a>
        <div>Last read: {formatDateTime(message.last_read_at_w3c)}</div>
    </div>
    <br />
    <h5>{message.subject}</h5>
    <div>{message.body}</div>
</div>
