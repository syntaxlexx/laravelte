<script>
    import MainLayout from './MainLayout.svelte'
    import { AppBar } from '@skeletonlabs/skeleton'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import { LightSwitch } from '@skeletonlabs/skeleton'

    $: auth = $page.props.auth.user

    let form = useForm()

    function handleLogout(e) {
        e.preventDefault()

        $form.post(route('logout'))
    }
</script>

<MainLayout>
    <svelte:fragment slot="header">
        <div class="bg-surface-100-800-token">
            <div class="container">
                <AppBar background="bg-transparent">
                    <svelte:fragment slot="lead">
                        <a href={route('admin.dashboard')} use:inertia>
                            <strong class="text-xl uppercase">{$page.props.siteName}</strong>
                        </a>
                    </svelte:fragment>

                    <svelte:fragment slot="trail">
                        <LightSwitch />

                        <form on:submit|preventDefault={handleLogout}>
                            <button type="submit" class="btn btn-sm variant-ghost-surface"> Logout </button>
                        </form>

                        <a class="btn btn-sm variant-ghost-surface" href="/dashboard" use:inertia> Profile </a>
                    </svelte:fragment>
                </AppBar>
            </div>
        </div>
    </svelte:fragment>

    <!-- content -->
    <slot />
</MainLayout>
