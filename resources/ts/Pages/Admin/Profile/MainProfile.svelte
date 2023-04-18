<script lang="ts">
    import { page } from '@inertiajs/svelte'
    import type { User } from '@/types'
    import AdminTitle from '../Components/AdminTitle.svelte'
    import { fromNow } from '@/helpers'

    let auth = $page.props.auth.user as User

    type ProfileItem = {
        text: string
        value: string | null | undefined
    }

    const infos: ProfileItem[] = [
        {
            text: 'Full Name',
            value: auth?.full_name,
        },
        {
            text: 'Email',
            value: auth.email,
        },
        {
            text: 'Phone',
            value: auth.phone ?? '-',
        },
        {
            text: 'Role',
            value: auth.role,
        },
        {
            text: 'Status',
            value: auth.status,
        },
        {
            text: 'Last login',
            value: fromNow(auth.last_login_at_w3c),
        },
        {
            text: 'Verified',
            value: fromNow(auth.verified_at_w3c),
        },
        {
            text: 'Joined on',
            value: fromNow(auth.created_at_w3c),
        },
        {
            text: 'Last updated on',
            value: fromNow(auth.updated_at_w3c),
        },
    ]
</script>

<div class="">
    <AdminTitle />
    <div>
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100">Main Profile</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Personal details about you.</p>
        </div>
        <div class="mt-5 border-t border-gray-200 dark:border-gray-800">
            <dl class="sm:divide-y sm:divide-gray-200">
                {#each infos as item}
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">{item.text}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{item.value}</dd>
                    </div>
                {/each}
            </dl>
        </div>
    </div>
</div>
