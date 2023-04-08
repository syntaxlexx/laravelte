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

<div class="">
    <Modal />

    {#if withShell}
        <AppShell regionPage="overflow-y-auto relative h-screen scrollbar-hidden">
            <Toast position="br" />
            <svelte:fragment slot="header">
                <slot name="header" />
            </svelte:fragment>

            <slot />

            <svelte:fragment slot="pageFooter">
                <slot name="footer" />
            </svelte:fragment>
        </AppShell>
    {:else}
        <Toast position="br" />
        <slot />
    {/if}
</div>
