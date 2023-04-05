<script lang="ts">
    import { AppShell, Toast, type ToastSettings, toastStore, Modal } from '@skeletonlabs/skeleton'
    import { page } from '@inertiajs/svelte'

    $: title = `${$page.props.title ?? 'Welcome'} | ${$page.props.siteName}`
    $: flashMessage = $page.props.flash

    export let withShell = false

    $: if (flashMessage && (flashMessage.success || flashMessage.error)) {
        const t: ToastSettings = {
            message: flashMessage.success || flashMessage.error,
            background: $page.props.flash.success === null ? 'variant-filled-error' : 'variant-filled-primary',
        }

        toastStore.trigger(t)
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<div style="display: contents" class="min-h-screen overflow-hidden">
    <Modal />

    {#if withShell}
        <AppShell>
            <Toast position="br" />
            <svelte:fragment slot="header">
                <slot name="header" />
            </svelte:fragment>

            <!-- other layout data -->
            <slot />
        </AppShell>
    {:else}
        <Toast position="br" />
        <slot />
    {/if}
</div>
