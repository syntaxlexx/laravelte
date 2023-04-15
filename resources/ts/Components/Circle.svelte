<script lang="ts">
	import Icon from './Icon.svelte';
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	function handleClick() {
		dispatch('click');
	}

	type CircleSize = 'sm' | 'lg' | 'xl' | 'n';
	type CircleColor = 'primary' | 'danger' | 'success' | 'error' | 'warning';

	export let icon = 'edit';
	export let size: CircleSize = 'sm';
	export let color: CircleColor = 'primary';

	$: btnSize =
		size == 'xl'
			? 'w-12 h-12 text-3xl'
			: size == 'lg'
			? 'w-10 h-10 text-2xl'
			: size == 'sm'
			? 'w-6 h-6 text-base'
			: 'w-8 h-8 text-xl';

	$: btnColor =
		color == 'primary'
			? 'blue'
			: color == 'success'
			? 'green'
			: color == 'warning'
			? 'yellow'
			: 'red';
</script>

<button
	type="button"
	class="{btnSize} rounded-full bg-{btnColor}-500 hover:bg-{btnColor}-600 focus:bg-{btnColor}-700 text-white flex flex-col items-center justify-center"
	on:click={handleClick}
	{...$$props}
>
	<Icon name={icon} />
</button>
