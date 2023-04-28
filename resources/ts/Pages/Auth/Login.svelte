<script lang="ts">
    import { useForm, router } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { Alert, Button, DisplayErrors, Icon, Input, Title } from '@/Components'
    import { toasts } from 'svelte-toasts'
    import { isEmail } from '@/helpers'

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

        $form.post(route('login'), {
            onSuccess: resp => {
                window.location.reload()
            },
        })
    }

    function sendLoginLink() {
        if (!isEmail($form.username)) {
            toasts.info('Please provide a valid email')
            return
        }

        router.post(route('login-via-magic-link'), {
            email: $form.username,
        })
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

                <Button color="ghost" type="button" block on:click={sendLoginLink}>
                    <Icon name="bx bxs-magic-wand" size="lg" />
                    Send Magic Login Link</Button
                >

                <p class="text-lg my-5 text-center">--OR--</p>

                {#if showPassword}
                    <Input
                        name="username"
                        hasError={$form.errors.username}
                        type="text"
                        placeholder="Password"
                        bind:value={$form.password}
                        suffixIcon="lock"
                        on:suffix={() => (showPassword = !showPassword)}
                    />
                {:else}
                    <Input
                        name="username"
                        hasError={$form.errors.username}
                        type="password"
                        placeholder="Password"
                        bind:value={$form.password}
                        suffixIcon="lock-open-alt"
                        on:suffix={() => (showPassword = !showPassword)}
                    />
                {/if}

                <!-- <label class="flex items-center space-x-2  my-3 ml-1">
                    <input class="checkbox" type="checkbox" bind:checked={$form.remember} />
                    <p>Remember Me</p>
                </label> -->

                <DisplayErrors errors={$form.errors} />

                <Button type="submit" text="Login" block disabled={$form.processing} loading={$form.processing} />
            </form>

            {#if canResetPassword}
                <br />
                <p>
                    <a href={route('forgot-password')}>Reset Password</a>
                </p>
            {/if}

            {#if canRegister}
                <br />
                <p class="text-right">
                    Don't have an account yet?
                    <a href={route('register')} class="underline">Register here</a>
                </p>
            {/if}
        </div>
    {/if}
</div>
