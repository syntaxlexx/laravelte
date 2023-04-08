<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { ProgressRadial } from '@skeletonlabs/skeleton'
    import Alert from '@/Components/Alert.svelte'

    let ready = false
    onMount(() => (ready = true))

    export let canRegister: boolean
    export let oauth_providers: string[]

    let form = useForm({
        username: '',
        password: '',
        confirmPassword: '',
        phone: '',
        email: '',
        first_name: '',
        last_name: '',
    })

    function handleSubmit(e) {
        e.preventDefault()

        $form.post(route('register'))
    }
</script>

<div class="container page-padding">
    {#if ready}
        {#if canRegister}
            <div class="mx-auto max-w-lg" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
                <h2 class="text-center">Register</h2>
                <p class="text-center">Fill in the form below</p>
                <br />
                <form on:submit|preventDefault={handleSubmit}>
                    <label class="label">
                        <input
                            class="input"
                            class:input-error={$form.errors.username}
                            type="text"
                            placeholder="Username / Email"
                            bind:value={$form.username}
                        />
                    </label>

                    {#if $form.errors.username}
                        <div class="form-error">{$form.errors.username}</div>
                    {/if}

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.username}
                            type="password"
                            placeholder="Password"
                            bind:value={$form.password}
                        />
                    </label>

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.confirmPassword}
                            type="password"
                            placeholder="Confirm Password"
                            bind:value={$form.password}
                        />
                    </label>

                    {#if $form.errors.password}
                        <div class="form-error">{$form.errors.password}</div>
                    {/if}

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.email}
                            type="email"
                            placeholder="Email"
                            bind:value={$form.email}
                        />
                    </label>

                    {#if $form.errors.email}
                        <div class="form-error">{$form.errors.email}</div>
                    {/if}

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.phone}
                            type="tel"
                            placeholder="Phone"
                            bind:value={$form.phone}
                        />
                    </label>

                    {#if $form.errors.phone}
                        <div class="form-error">{$form.errors.phone}</div>
                    {/if}

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.first_name}
                            type="text"
                            placeholder="First Name"
                            bind:value={$form.first_name}
                        />
                    </label>

                    {#if $form.errors.first_name}
                        <div class="form-error">{$form.errors.first_name}</div>
                    {/if}

                    <label class="label my-3">
                        <input
                            class="input"
                            class:input-error={$form.errors.last_name}
                            type="text"
                            placeholder="Last Name"
                            bind:value={$form.last_name}
                        />
                    </label>

                    {#if $form.errors.last_name}
                        <div class="form-error">{$form.errors.last_name}</div>
                    {/if}

                    <button class="btn variant-filled w-full" type="submit" disabled={$form.processing}>
                        Register

                        {#if $form.processing}
                            <span class="ml-4">
                                <ProgressRadial
                                    width="w-8"
                                    stroke={100}
                                    meter="stroke-primary-500"
                                    track="stroke-primary-500/30"
                                />
                            </span>
                        {/if}
                    </button>
                </form>
            </div>
        {:else}
            <Alert>
                <svelte:fragment slot="title">Registration Closed!</svelte:fragment>
                Contact the admin for more info
            </Alert>
        {/if}
    {/if}
</div>
