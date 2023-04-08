<script lang="ts">
    import Title from '@/Components/Title.svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { formatDate } from '@/helpers'

    let ready = false
    onMount(() => (ready = true))

    export let title: string
    export let content: string
    export let updated_at: Date
</script>

<div class="container page-padding" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Title>{title}</Title>
    <br />
    <p>Last Updated {formatDate(updated_at)}.</p>
    <div class="my-8">
        {@html content}
    </div>
</div>
