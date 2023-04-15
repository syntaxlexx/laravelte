<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import Alert from '@/Components/Alert.svelte'
    import { Button, Input, Loading, Title } from '@/Components'

    let ready = false
    onMount(() => (ready = true))

    export let canRegister: boolean
    export let oauth_providers: string[]

    let form = useForm({
        username: '',
        password: '',
        password_confirmation: '',
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
                <Title>Register</Title>
                <p class="text-center">Fill in the form below</p>
                <br />
                <form on:submit|preventDefault={handleSubmit}>
                    <Input
                        name="username"
                        label="Username"
                        oneLine
                        hasError={$form.errors.username}
                        type="text"
                        placeholder="Username"
                        bind:value={$form.username}
                        required
                    />

                    <Input
                        name="password"
                        label="Password"
                        oneLine
                        hasError={$form.errors.password}
                        type="password"
                        placeholder="Password"
                        bind:value={$form.password}
                    />

                    <Input
                        name="password"
                        label="Confirm Password"
                        oneLine
                        hasError={$form.errors.password_confirmation}
                        type="password"
                        placeholder="Confirm Password"
                        bind:value={$form.password_confirmation}
                    />

                    <Input
                        name="email"
                        label="Email"
                        oneLine
                        hasError={$form.errors.email}
                        type="email"
                        placeholder="email@gmail.com"
                        bind:value={$form.email}
                        required
                    />

                    <Input
                        name="phone"
                        label="Phone"
                        oneLine
                        hasError={$form.errors.phone}
                        type="tel"
                        placeholder="[+country code][number]"
                        bind:value={$form.phone}
                    />

                    <Input
                        name="first_name"
                        label="First Name"
                        oneLine
                        hasError={$form.errors.first_name}
                        type="text"
                        placeholder="John"
                        bind:value={$form.first_name}
                        required
                    />

                    <Input
                        name="last_name"
                        label="Last Name"
                        oneLine
                        hasError={$form.errors.last_name}
                        type="text"
                        placeholder="Doe"
                        bind:value={$form.last_name}
                    />

                    <Button type="submit" block loading={$form.processing}>Register</Button>
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
