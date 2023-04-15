<script lang="ts">
    import { page } from '@inertiajs/svelte'
    import { ToastContainer, FlatToast, toasts } from 'svelte-toasts'
    import { Modals, closeModal } from 'svelte-modals'

    $: title = `${$page.props.title ?? 'Welcome'} | ${$page.props.siteName}`
    $: flashMessage = $page.props.flash

    $: if (flashMessage && (flashMessage.success || flashMessage.error)) {
        $page.props.flash.success === null
         ? toasts.error(flashMessage.error)
         : toasts.success(flashMessage.success)
    }
</script>

<svelte:head>
    <title>{title}</title>
</svelte:head>

<Modals>
    <div slot="backdrop" class="backdrop" on:click={closeModal} tabindex="0" role="button" />
</Modals>

<div class="">
	<slot />

    <ToastContainer placement="bottom-right" showProgress={true} width="320px" let:data>
        <FlatToast {data} />
    </ToastContainer>
</div>
