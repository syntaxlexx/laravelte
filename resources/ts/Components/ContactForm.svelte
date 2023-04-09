<script lang="ts">
    import { page, useForm } from '@inertiajs/svelte'
    import Button from './Button.svelte'
    import ValidationErrors from './ValidationErrors.svelte'
    import { quadOut } from 'svelte/easing'
    import { slide } from 'svelte/transition'

    let saved = false
    let successMessage = ''

    let form = useForm({
        name: '',
        email: '',
        body: '',
        subject: '',
        phone: '',
    })

    function handleSubmit(e) {
        e.preventDefault()

        $form.post(route('contact.store'), {
            onSuccess: () => {
                saved = true
                successMessage = $page.props.flash.success || 'We shall get in touch'
            },
        })
    }
</script>

{#if saved}
    <div
        class="card p-8 bg-success-active-token items-center flex gap-4"
        in:slide={{ axis: 'y', duration: 300, easing: quadOut }}
    >
        <i class="bx bx-check-circle text-xl" />
        <span class="text-xl">
            {successMessage}
        </span>
    </div>
{:else}
    <form class="card" on:submit|preventDefault={handleSubmit} in:slide={{ axis: 'y', duration: 300, easing: quadOut }}>
        <header class="card-header">
            <h3>Leave us a Beautiful Message</h3>
            <p>We promise to reply</p>
        </header>

        <section class="p-4">
            <label class="label" for="name">
                <span class="sr-only">Names</span>
                <input
                    class="input"
                    type="text"
                    id="name"
                    placeholder="Your Names *"
                    bind:value={$form.name}
                    required
                />
            </label>
            <label class="label" for="email">
                <span class="sr-only">Email</span>
                <input class="input" type="email" id="email" placeholder="Your Email" bind:value={$form.email} />
            </label>
            <label class="label" for="phone">
                <span class="sr-only">Phone</span>
                <input class="input" type="tel" id="phone" placeholder="Phone" bind:value={$form.phone} />
            </label>
            <label class="label" for="subject">
                <span class="sr-only">Subject</span>
                <input class="input" type="text" id="subject" placeholder="Subject" bind:value={$form.subject} />
            </label>
            <label class="label" for="body">
                <span class="sr-only">Message</span>
                <textarea
                    class="textarea"
                    rows="4"
                    id="body"
                    placeholder="Write your message"
                    bind:value={$form.body}
                />
            </label>

            <ValidationErrors errors={$form.errors} />
        </section>

        <footer class="card-footer">
            <Button type="submit" loading={$form.processing}>Send Message</Button>
        </footer>
    </form>
{/if}
