<script lang="ts">
    import Title from '@/Components/Title.svelte'
    import { inertia } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import Sweet from '@/Components/Sweet.svelte'

    let ready = false
    onMount(() => (ready = true))
</script>

<div class="container page-padding" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
    <Title>About Us</Title>
    <br />

    <div class="flex flex-wrap">
        <div class="w-full lg:w-1/2">
            <p>
                <span class="text-lg font-bold">Laravelte</span> is packed with features and functionality
                <strong>out-of-the-box</strong> to help with quickly scaffolding your next application.
            </p>
            <br />
            <h4 class="underline underline-offset-4 mb-2">Some features include:</h4>
            <ul class="list-disc">
                <li>
                    <strong>Typescript</strong> Support for an even better <strong>Developer eXperience (DX)</strong>
                </li>
                <li>
                    <strong>Svelte 💍 Inertiajs</strong> - The marriage we never knew we wanted!
                </li>
                <li>
                    <strong>Laravel Backend</strong> - We could say a lot; but what is even left to say? It speaks for itself!
                </li>
                <li>
                    <strong>Laravel Actions</strong> - No messy controllers! More on this later
                </li>
                <li>
                    <strong>Pest Tests</strong> that ensure your ship quality products with
                    <strong>Ease of mind</strong>
                </li>
                <li>
                    <strong>Github CI/CD</strong> for an even smoother shipping to production.
                    <strong>Fully customizable</strong>
                </li>
            </ul>
        </div>
        <div class="w-full lg:w-1/2">
            <div class="px-4 mt-12 lg:mt-0">
                <figure class="mx-auto">
                    <img src="/img/laravelte-screenshot-5.png" alt="screenshot" />
                    <figcaption>A screenshot showing some successful tests earier on in project development</figcaption>
                </figure>
            </div>
        </div>
    </div>
    <div class="flex flex-wrap mt-12">
        <div class="w-full lg:w-1/2">
            <img src="/img/laravelte-screenshot-6.png" alt="laravelte" class="mx-auto pr-5" />
        </div>
        <div class="w-full lg:w-1/2 mt-12 lg:mt-0">
            <h3 class="mb-4 underline underline-offset-8">What - and why - is Laravel Actions?</h3>
            <p>Laravel Actions is one of those things you didn't know you needed till you used it.</p>
            <p>
                The mindset shits focus from thinking about controllers, and instead become more <strong
                    >intimate</strong
                > with your application functionality
            </p>
            <br />
            <blockquote>
                we shift our focus from "What controllers do I need?", "should I make a FormRequest for this?", "should
                this run asynchronously in a job instead?", etc.
            </blockquote>
            <p class="my-4">to</p>
            <blockquote>"What does my application actually do?" Kinda like RPC</blockquote>
            <p class="mt-8">
                However, we don't go full gun-blazing by taking all the principles outlined by the <a
                    href="https://laravelactions.com/"
                    target="_blank">Author of the application.</a
                >
            </p>
            <br />
            <p>Instead,</p>
            <ul class="list-disc pl-8">
                <li>Complex FormRequests</li>
                <li>Jobs</li>
                <li>Events</li>
                <li>Listeners</li>
                <li>Commands</li>
                <li>Middlewares</li>
                <li>e.t.c</li>
            </ul>
            <p>are left as per their defaults.</p>
            <p>
                Actions are - technically, <strong>Controllers!</strong>. They handle most of the logic (view them as
                kind of like-components), dispatch jobs, fire events, validate requests, e.t.c. This approach ensures
                <strong>easier Maintainability</strong> and no <strong>mental fatigue</strong> in the long run.
            </p>
        </div>
    </div>

    <Sweet />
</div>
