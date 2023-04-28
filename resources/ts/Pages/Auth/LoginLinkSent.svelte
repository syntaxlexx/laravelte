<script lang="ts">
    import { Title } from '@/Components'
    import { onMount } from 'svelte'
    import { quintOut } from 'svelte/easing'
    import { fly } from 'svelte/transition'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="container page-padding">
    {#if ready}
        <div class="mx-auto max-w-lg" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <Title>Magic Login Link Sent</Title>
            <br />
            We have sent a login link to the email address.
            <br />
            If the account exists, you shall receive the email.
        </div>
    {/if}
</div>
