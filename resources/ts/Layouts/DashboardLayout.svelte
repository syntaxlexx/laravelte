<script lang="ts">
    import MainLayout from './MainLayout.svelte'
	import { AppBar } from '@skeletonlabs/skeleton';
    import { page, inertia } from "@inertiajs/svelte";
    import { LightSwitch } from '@skeletonlabs/skeleton';

    $: auth = $page.props.auth.user;
</script>

<MainLayout>
    <svelte:fragment slot="header">
        <div class="container">
            <AppBar>
                <svelte:fragment slot="lead">
                    <a href={route('dashboard')} use:inertia>
                        <strong class="text-xl uppercase">{$page.props.siteName}</strong>
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
                        href={route('dashboard')}
                        use:inertia
                    >
                        Profile
                    </a>
                </svelte:fragment>
            </AppBar>
        </div>
    </svelte:fragment>

    <!-- content -->
    <slot />

</MainLayout>
