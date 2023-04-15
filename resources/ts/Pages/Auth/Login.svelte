<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { Button, Input, Loading, Title } from '@/Components'

    let ready = false
    onMount(() => (ready = true))

    export let canResetPassword: boolean
    export let canRegister: boolean
    export let status: string
    export let oauth_providers: string[]
    export let username: string | null
    export let password: string | null
    export let is_demo: boolean = false

    let showPassword = false

    let form = useForm({
        username: username,
        password: password,
        remember: false,
    })

    function handleSubmit(e) {
        e.preventDefault()

        $form.post(route('login'))
    }
</script>

<div class="container page-padding">
    {#if ready}
        <div class="mx-auto max-w-lg" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <Title>Login</Title>
            <p class="text-center">Fill in the form below</p>
            <br />
            {#if is_demo}
                <div class="card p-3">
                    <h5 class="text-center">Demo Logins</h5>
                    <div class="flex justify-between">
                        <div>
                            <p>Admin</p>
                            <p>username: <strong>admin</strong></p>
                            <p>Password: <strong>admin</strong></p>
                        </div>
                        <div>
                            <p>User</p>
                            <p>username: <strong>user</strong></p>
                            <p>Password: <strong>user</strong></p>
                        </div>
                    </div>
                </div>
                <br />
            {/if}
            <form on:submit|preventDefault={handleSubmit}>
                <Input
                    name="username"
                    hasError={$form.errors.username}
                    type="text"
                    placeholder="Username / Email"
                    bind:value={$form.username}
                />

                <div class="my-3 relative">
                    {#if showPassword}
                        <Input
                            name="username"
                            hasError={$form.errors.username}
                            type="text"
                            placeholder="Password"
                            bind:value={$form.password}
                        />
                    {:else}
                        <Input
                            name="username"
                            hasError={$form.errors.username}
                            type="password"
                            placeholder="Password"
                            bind:value={$form.password}
                        />
                    {/if}

                    <div class="absolute right-5 top-2">
                        <button class="no-style" type="button" on:click={() => (showPassword = !showPassword)}>
                            <i class="bx bx-lock text-lg" />
                        </button>
                    </div>
                </div>

                <!-- <label class="flex items-center space-x-2  my-3 ml-1">
                    <input class="checkbox" type="checkbox" bind:checked={$form.remember} />
                    <p>Remember Me</p>
                </label> -->

                <Button type="submit" block disabled={$form.processing} loading={$form.processing}>Submit</Button>
            </form>

            {#if canResetPassword}
                <br />
                <p>
                    <a href={route('forgot-password')}>Reset Password</a>
                </p>
            {/if}

            {#if canRegister}
                <br />
                <p>
                    Don't have an account yet?
                    <a href={route('register')}>Register here</a>
                </p>
            {/if}
        </div>
    {/if}
</div>
