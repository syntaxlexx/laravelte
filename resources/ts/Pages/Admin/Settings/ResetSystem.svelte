<script lang="ts">
    import type { ResetSystemAction } from '@/types'
    import { useForm } from '@inertiajs/svelte'
    import Title from '@/Components/Title.svelte'
    import { Button } from '@/Components'

    export let actions: ResetSystemAction[]

    let form = useForm({
        action: '',
    })

    function handleClick(action: ResetSystemAction) {
        $form.action = action.action

        $form.post(route('admin.settings.reset-system'))
    }
</script>

<div class="mt-5">
    <Title>Reset System</Title>
    <br />
    <div class="card p-4">
        <div class="flex flex-wrap gap-4">
            {#each actions as item}
                <Button color="primary" loading={$form.processing} on:click={() => handleClick(item)}
                    >{item.text}</Button
                >
            {/each}
        </div>
    </div>
</div>
