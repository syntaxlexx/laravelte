<script lang="ts">
    import Title from '@/Components/Title.svelte'
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import ContactForm from '@/Components/ContactForm.svelte'

    let ready = false
    onMount(() => (ready = true))

    export let country: string | null
</script>

<div class="container page-padding" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Title>Contact Us</Title>
    <br />

    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2"><ContactForm /></div>
        <div class="w-full lg:w-1/2">
            <div class="p-4">
                {#if country}
                    <p>Visiting us from {country}? Hi 🙃. We might be 50% wrong though.</p>
                    <br />
                    <div style="width: 100%">
                        <iframe
                            width="100%"
                            height="400"
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={country}&amp;t=&amp;z=6&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"
                            ><a href="https://www.maps.ie/distance-area-calculator.html">measure distance on map</a
                            ></iframe
                        >
                    </div>
                {/if}
            </div>
        </div>
    </div>
</div>
