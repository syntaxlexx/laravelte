<script>
	import ModalClose from './ModalClose.svelte';

	// provided by <Modals />
	export let isOpen;

	export let title;
	export let message;

	// usage
	// import { openModal } from 'svelte-modals';
	// import Modal from '$lib/components/Modal.svelte';
	//
	// function handleClick() {
	// 	openModal(Modal, { title: 'Alert', message: 'This is an alert' });
	// }
	//
	// <button on:click={handleClick}>Open Modal</button>
</script>

{#if isOpen}
	<div role="dialog" class="modal">
		<div class="modal-content-container">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title">
						{title}
					</h3>
					<ModalClose />
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<slot>{message}</slot>
				</div>
			</div>
		</div>
	</div>
{/if}
