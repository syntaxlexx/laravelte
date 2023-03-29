<script lang="ts">
    import { AppShell } from "@skeletonlabs/skeleton";
    import { page } from "@inertiajs/svelte";

    $: title = `${$page.props.title ?? "Welcome"} | ${$page.props.appName}`
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<div style="display: contents" class="h-full overflow-hidden">
    <AppShell>
        <svelte:fragment slot="header">
            <slot name="header" />
        </svelte:fragment>

        <!-- other layout data -->
        <slot />

    </AppShell>
</div>
