<script lang="ts">
    import { onMount } from 'svelte'

    export let text = 'Hello'
    type ButtonSize = 'n' | 'sm' | 'lg'
    export let size: ButtonSize = 'n'

    let btnElement: HTMLButtonElement

    onMount(() => {
        btnElement.addEventListener('mousemove', e => {
            let rect = e.target?.getBoundingClientRect()
            let x = e.clientX * 3 - rect.left
            btnElement.style.setProperty('--x', `${x}deg`)
        })

        btnElement.addEventListener('mouseleave', e => {
            btnElement.style.setProperty('--x', `45deg`)
        })
    })
</script>

<button {...$$restProps} bind:this={btnElement} class="fancy-btn-{size}">
    <i />
    <i />
    <span class="overlay">&nbsp</span>
    <span class="relative text-white">
        <slot>
            {text}
        </slot>
    </span>
</button>

<style lang="css">
    :root {
        --x: 45deg;
    }
    button.fancy-btn-n {
        @apply px-5 py-2.5;
    }
    button.fancy-btn-sm {
        @apply px-4 py-2;
    }
    button.fancy-btn-lg {
        @apply px-6 py-3;
    }
    button {
        @apply relative -inset-[2px] inline-block rounded;
    }
    button i {
        @apply absolute -inset-[2px] block  rounded;
    }
    button i,
    button i:nth-child(2) {
        background: linear-gradient(var(--x), #00ccff, #0e1538, #0e1538, #d400d4);
    }
    button i:nth-child(2) {
        filter: blur(10px);
    }
    button span.overlay {
        @apply absolute top-0 left-0 w-full h-full flex justify-center items-center bg-gray-900/70 uppercase text-white rounded border-primary-900 overflow-hidden;
        letter-spacing: 2px;
    }
    button span.overlay:before {
        content: '';
        @apply absolute top-0 left-[-50%] w-full h-full bg-white/[0.075];
        transform: skew(25deg);
    }
</style>
