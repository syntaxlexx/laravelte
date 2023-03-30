<script lang="ts">
    import { AppShell, Toast, type ToastSettings, toastStore } from "@skeletonlabs/skeleton";
    import { page } from "@inertiajs/svelte";

    $: title = `${$page.props.title ?? "Welcome"} | ${$page.props.siteName}`
    $: flashMessage = $page.props.flash.message

    $: if(flashMessage) {
        const t : ToastSettings = {
            message: flashMessage,
            background: $page.props.flash.type == 'error' ? 'variant-filled-error' : 'variant-filled-primary',
        }

        toastStore.trigger(t)
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<div style="display: contents" class="h-full overflow-hidden">
    <AppShell>
        <Toast />
        <svelte:fragment slot="header">
            <slot name="header" />
        </svelte:fragment>

        <!-- other layout data -->
        <slot />

    </AppShell>
</div>
