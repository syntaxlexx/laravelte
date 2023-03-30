<script lang="ts">
    import {page, inertia} from '@inertiajs/svelte'
    import Layout from "../Layouts/AppLayout.svelte";

    export let canLogin: boolean;
    export let canRegister: boolean;
    export let laravelVersion : string;
    export let phpVersion : string;
</script>

<svelte:head>
    <title>Welcome</title>
</svelte:head>

<div class="container mt-12 h-full mx-auto flex justify-center items-center">
	<div class="space-y-10 text-center">
		<h2 class="font-bold">Welcome to {$page.props.siteName}.</h2>
        <figure>
			<section class="img-bg" />
            <img src="/img/laravelte-logo.png" alt="logo" class="h-12 md:h-16 lg:h-24 w-auto"/>
        </figure>
		<div class="flex justify-center space-x-2">
			<a class="btn btn-filled" href="https://skeleton.dev/" target="_blank" rel="noreferrer">
				Powered by<strong class="ml-1 underline">Skeleton UI (TailwindCSS)</strong>
			</a>
		</div>
		<div class="space-y-2">
            <div class="flex flex-col md:flex-wrap lg:flex-row gap-2">
                <p>Login Enabled: {canLogin}</p>
                <span class="hidden lg:block">&middot;</span>
                <p>Registeration Enabled: {canRegister}</p>
                <span class="hidden lg:block">&middot;</span>
                <p>Laravel Version: {laravelVersion}</p>
                <span class="hidden lg:block">&middot;</span>
                <p>PHP Version: {phpVersion}</p>
            </div>
            <a href={route('about')} use:inertia>About</a>
		</div>
	</div>
</div>

<style lang="postcss">
	figure {
		@apply flex relative flex-col;
	}
	.img-bg {
		@apply h-12 md:h-16 lg:h-24 w-full;
	}
	.img-bg {
		@apply absolute z-[-1] rounded-full blur-[50px] transition-all;
		animation: pulse 5s cubic-bezier(0, 0, 0, 0.5) infinite, glow 5s linear infinite;
	}
	@keyframes glow {
		0% {
			@apply bg-primary-400/50;
		}
		33% {
			@apply bg-secondary-400/50;
		}
		66% {
			@apply bg-tertiary-400/50;
		}
		100% {
			@apply bg-primary-400/50;
		}
	}
	@keyframes pulse {
		50% {
			transform: scale(1.5);
		}
	}
</style>
