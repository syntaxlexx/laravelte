<script lang="ts">
    import MainLayout from './MainLayout.svelte'
    import { page, inertia, useForm } from '@inertiajs/svelte'
    import UserSidebar from '@/Components/UserSidebar.svelte'
    import { Button, Icon, ThemeSwitcher } from '@/Components'

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
    <div class="user-dashboard flex flex-wrap">
        <div class="w-full md:w-72 hidden md:block">
            <div class=" bg-gray-100 dark:bg-gray-800 h-full w-full">
                <div class="p-5 pt-6">
                    <UserSidebar />
                </div>
            </div>
        </div>

        <div class="w-full md:flex-1 bg-white dark:bg-gray-900">
            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                <h3 class="text-xl font-semibold">
                    {$page.props.title}
                </h3>
                <div />
                <div class="flex gap-2 items-center">
                    <Icon name="bell" classes="text-2xl text-gray-600 dark:text-gray-300" />
                    <Icon name="message" classes="text-2xl text-gray-600 dark:text-gray-300" />
                    <ThemeSwitcher />
                    <Button size="sm">Share</Button>
                    <Button size="sm" color="secondary">Create</Button>
                </div>
            </div>

            <slot />
        </div>
    </div>
</MainLayout>

<style lang="css">
    .user-dashboard {
        @apply bg-gray-100 dark:bg-gray-800 min-h-screen;
    }
</style>
