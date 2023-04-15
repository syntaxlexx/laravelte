<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import type { SystemConfiguration } from '@/types'
    import { snakeCaseToSentenceCaseCapitalizeWords } from '@/helpers'
    import Button from '@/Components/Button.svelte'

    // Base Classes
    const cBase = 'card p-4 w-modal shadow-xl space-y-4'
    const cHeader = 'text-2xl font-bold'
    const cForm = 'border border-surface-500 p-4 space-y-4 rounded-container-token'

    // Props
    /** Exposes parent props to this component. */
    export let parent: any
    export let configuration: SystemConfiguration
    export let title: string

    // Form Data
    let form = useForm({
        name: configuration.name,
        id: configuration.id,
        value: configuration.value,
    })

    function handleSubmit(): void {
        $form.post(route('admin.settings.configurations'), {
            onSuccess: () => {
                // modalStore.close()
            },
        })
    }
</script>

<div class={cBase}>
    <header class={cHeader}>{title}</header>

    <form on:submit|preventDefault={handleSubmit}>
        <div class="modal-form {cForm}" on:submit|preventDefault={handleSubmit}>
            <label class="label">
                <span>Name</span>
                <input
                    class="input"
                    type="text"
                    required
                    value={snakeCaseToSentenceCaseCapitalizeWords(configuration.name)}
                    disabled
                    placeholder="Name"
                />
            </label>
            {#if configuration.type == 'bool'}
                <label class="flex items-center space-x-2">
                    <p>Value</p>
                    <input class="checkbox" type="checkbox" bind:checked={$form.value} />
                </label>
            {:else if configuration.type == 'number'}
                <label class="label">
                    <span>Value</span>
                    <input class="input" type="number" required bind:value={$form.value} placeholder="Value" />
                </label>
            {:else}
                <label class="label">
                    <span>Value</span>
                    <input class="input" type="text" required bind:value={$form.value} placeholder="Value" />
                </label>
            {/if}
        </div>

        <footer class="modal-footer {parent.regionFooter}">
            <Button color="ghost" type="button" on:click={parent.onClose}>{parent.buttonTextCancel}</Button>
            <Button type="submit" loading={$form.processing}>Submit</Button>
        </footer>
    </form>
</div>
