<script lang="ts">
    import MainLayout from './MainLayout.svelte'
	import { AppBar } from '@skeletonlabs/skeleton';
    import { page, inertia } from "@inertiajs/svelte";
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

                {#if auth}
                    <a
                        class="btn btn-sm variant-ghost-surface"
                        href="/dashboard"
                    >
                        Dashboard
                    </a>
                    <form action="/logout" method="POST">
                        <button
                            type="submit"
                            class="btn btn-sm variant-ghost-surface"
                        >
                            Logout
                        </button>
                    </form>
                {:else}
                    <a class="btn btn-sm variant-ghost-surface" href="/login">
                        Login
                    </a>
                    <a
                        class="btn btn-sm variant-ghost-surface"
                        href="/register"
                    >
                        Register
                    </a>
                {/if}

                <a
                    class="btn btn-sm variant-ghost-surface"
                    href="/dashboard"
                    use:inertia
                >
                    Dash
                </a>
                <a
                    class="btn btn-sm variant-ghost-surface"
                    href="https://twitter.com/SkeletonUI"
                    target="_blank"
                    rel="noreferrer"
                >
                    Twitter
                </a>
                <a
                    class="btn btn-sm variant-ghost-surface"
                    href="https://github.com/skeletonlabs/skeleton"
                    target="_blank"
                    rel="noreferrer"
                >
                    GitHub
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
