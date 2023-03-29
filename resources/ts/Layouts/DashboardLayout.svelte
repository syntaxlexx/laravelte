<script lang="ts">
    import MainLayout from './MainLayout.svelte'
	import { AppBar } from '@skeletonlabs/skeleton';
    import { page } from "@inertiajs/svelte";
    import { LightSwitch } from '@skeletonlabs/skeleton';

    $: auth = $page.props.auth.user;
</script>

<MainLayout>
    <svelte:fragment slot="header">
        <!-- App Bar -->
        <AppBar>
            <svelte:fragment slot="lead">
                <a href="/">
                    <strong class="text-xl uppercase">{$page.props.appName}</strong>
                </a>
            </svelte:fragment>

            <svelte:fragment slot="trail">
                <LightSwitch/>

                    <form action="/logout" method="POST">
                        <button
                            type="submit"
                            class="btn btn-sm variant-ghost-surface"
                        >
                            Logout
                        </button>
                    </form>

                <a
                    class="btn btn-sm variant-ghost-surface"
                    href="/"
                    target="_blank"
                    rel="noreferrer"
                >
                    Profile
                </a>
            </svelte:fragment>
        </AppBar>
    </svelte:fragment>

    <!-- Page Route Content -->
    {#if $page.props.flash.message}
        <div class="alert">{$page.props.flash.message}</div>
    {/if}

    <!-- content -->
    <slot />

</MainLayout>
