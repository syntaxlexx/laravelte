<script>
    import { Title } from '@/Components'
    import { page } from '@inertiajs/svelte'
</script>

<Title bgColor="bg-gray-100 dark:bg-gray-900"
    ><slot>
        {$page.props.title}
    </slot></Title
>
