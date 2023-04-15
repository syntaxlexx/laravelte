<script lang="ts">
    import MainLayout from './MainLayout.svelte'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import AdminSidebar from '@/Components/AdminSidebar.svelte'

    $: auth = $page.props.auth.user

    let form = useForm()

    function handleLogout(e) {
        e.preventDefault()

        $form.post(route('logout'))
    }

    function drawerOpen(): void {
        // drawerStore.open({})
    }
</script>

<MainLayout>
    <AppShell
        slotSidebarLeft="bg-surface-500/5 w-0 lg:w-64"
        regionPage="overflow-y-auto relative h-screen scrollbar-hidden"
    >
        <svelte:fragment slot="header">
            <div class="bg-surface-100-800-token">
                <div class="container">
                    <AppBar background="bg-transparent">
                        <svelte:fragment slot="lead">
                            <button class="lg:hidden btn btn-sm mr-4" on:click={drawerOpen}>
                                <span>
                                    <svg viewBox="0 0 100 80" class="fill-token w-4 h-4">
                                        <rect width="100" height="20" />
                                        <rect y="30" width="100" height="20" />
                                        <rect y="60" width="100" height="20" />
                                    </svg>
                                </span>
                            </button>
                            <a href={route('admin.dashboard')} use:inertia>
                                <strong class="text-xl uppercase">{$page.props.siteName}</strong>
                            </a>
                        </svelte:fragment>

                        <svelte:fragment slot="trail">
                            <LightSwitch />

                            <form on:submit|preventDefault={handleLogout}>
                                <button type="submit" class="btn btn-sm variant-ghost-surface"> Logout </button>
                            </form>

                            <span class="hidden lg:block">
                                <a class="btn btn-sm variant-ghost-surface" href={route('admin.profile')} use:inertia>
                                    Profile
                                </a>
                            </span>
                        </svelte:fragment>
                    </AppBar>
                </div>
            </div>
        </svelte:fragment>

        <!-- sidebar -->
        <Drawer regionDrawer="mt-16 w-56 pb-16">
            <AdminSidebar />
        </Drawer>

        <svelte:fragment slot="sidebarLeft">
            <div id="sidebar-left" class="hidden lg:block">
                <div class="overflow-y-auto h-screen">
                    <AdminSidebar />
                </div>
            </div>
        </svelte:fragment>

        <!-- content -->
        <slot />
        <div class="my-4" />
    </AppShell>
</MainLayout>
