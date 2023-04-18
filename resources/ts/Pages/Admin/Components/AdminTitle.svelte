<script lang="ts">
    import { Title } from '@/Components'
    import { page } from '@inertiajs/svelte'

    export let title: string | null = $page.props.title
</script>

<Title bgColor="bg-gray-100 dark:bg-gray-900"
    ><slot>
        {title}
    </slot></Title
>
