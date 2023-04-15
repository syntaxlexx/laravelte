<script lang="ts">
    import { useForm } from '@inertiajs/svelte'
    import type { SystemConfiguration } from '@/types'
    import { snakeCaseToSentenceCaseCapitalizeWords } from '@/helpers'
    import { closeModal } from 'svelte-modals'
    import { Button, Input } from '@/Components'

    export let isOpen: boolean
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
                closeModal()
            },
        })
    }
</script>

{#if isOpen}
    <div role="dialog" class="modal">
        <div class="modal-content-container">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">{title}</div>
                </div>
                <div class="modal-body">
                    <form on:submit|preventDefault={handleSubmit}>
                        <div class="" on:submit|preventDefault={handleSubmit}>
                            <Input
                                type="text"
                                required
                                value={snakeCaseToSentenceCaseCapitalizeWords(configuration.name)}
                                disabled
                                placeholder="Name"
                                label="Name"
                                name="name"
                            />

                            {#if configuration.type == 'bool'}
                                <label class="flex items-center space-x-2">
                                    <p>Value</p>
                                    <input class="checkbox" type="checkbox" bind:checked={$form.value} />
                                </label>
                            {:else if configuration.type == 'number'}
                                <Input
                                    class="input"
                                    type="number"
                                    name="value"
                                    required
                                    bind:value={$form.value}
                                    placeholder="Value"
                                    label="Value"
                                />
                            {:else}
                                <Input
                                    name="value"
                                    type="text"
                                    required
                                    bind:value={$form.value}
                                    placeholder="Value"
                                    label="Value"
                                />
                            {/if}
                        </div>

                        <footer class="modal-footer">
                            <Button color="ghost" type="button" on:click={closeModal}>Cancel</Button>
                            <Button type="submit" loading={$form.processing}>Submit</Button>
                        </footer>
                    </form>
                </div>
            </div>
        </div>
    </div>
{/if}
