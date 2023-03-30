<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import { fly } from 'svelte/transition'
    import { quintOut } from 'svelte/easing'
    import { onMount } from 'svelte'
    import { ProgressRadial } from '@skeletonlabs/skeleton'

    let ready = false
    onMount(() => (ready = true))

    export let canResetPassword: boolean
    export let canRegister: boolean
    export let status: string
    export let oauth_providers: string[]

    let form = useForm({
        username: '',
        password: '',
        remember: false,
    })

    function handleSubmit(e) {
        e.preventDefault()

        $form.post(route('login'))
    }
</script>

<div class="container mt-5">
    {#if ready}
        <div class="mx-auto max-w-lg" in:fly={{ y: -70, duration: 300, easing: quintOut }}>
            <h2 class="text-center">Login</h2>
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

                <!-- <label class="flex items-center space-x-2  my-3 ml-1">
                    <input class="checkbox" type="checkbox" bind:checked={$form.remember} />
                    <p>Remember Me</p>
                </label> -->

                <button class="btn variant-filled w-full" type="submit" disabled={$form.processing}>
                    Submit

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
    {/if}
</div>
