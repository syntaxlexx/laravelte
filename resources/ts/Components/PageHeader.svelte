<script lang="ts">
    export let title: string
    export let description: string | undefined = undefined

    import { onMount } from 'svelte'

    let images = ['/img/header-1.jpg', '/img/header-2.jpg', '/img/header-3.jpg']

    $: image = images[randomNumber(0, images.length - 1)]

    onMount(() => {
        const styleTag = document.createElement('style')
        styleTag.innerHTML = `#page-header::before { background-image: url(${image}); }`
        document.head.insertAdjacentElement('beforeend', styleTag)
    })
</script>

<div
    id="page-header"
    class="relative dark:bg-gray-900/20 pb-8 lg:pb-16 lg:overflow-hidden pt-[85px] sm:pt-[95px] lg:pt-[105px]"
>
    <div class="container">
        <h2 class="text-gray-700 font-bold text-4xl">{title}</h2>
        {#if description}
            <p class="py-3 text-leading text-gray-600">{description}</p>
        {/if}
    </div>
</div>

<style>
    #page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: -1;
        /* background-image: url(image); */
        background-size: cover;
        background-position: center;
        opacity: 0.3;
    }
</style>
