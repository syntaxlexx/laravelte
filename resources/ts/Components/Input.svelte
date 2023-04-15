<script lang="ts">
    import { Icon } from '.'

    type InputColor = 'primary' | 'default'

    export let value: string | null = null
    export let color: InputColor = 'primary'
    export let label: string | undefined = undefined
    export let name: string
    export let classes: string = ''
    export let hasError: boolean | undefined = undefined
    export let oneLine: boolean | undefined = undefined
    export let noMb: boolean | undefined = undefined // no margin bottom

    export let prefixIcon: string | undefined = undefined
</script>

<div class:mb-6={!noMb}>
    <div class="flex {oneLine ? 'flex-row items-center' : 'flex-col'}">
        <div class={oneLine ? 'w-full md:w-2/4 lg:w-1/4' : ''}>
            {#if label}
                <label for={name} class="block mb-2 text-sm font-medium label-{color}">{label}</label>
            {:else}
                <label for={name} class="sr-only">{name}</label>
            {/if}
        </div>

        <div class={oneLine ? 'w-full md:w-2/4 lg:w-3/4' : ''}>
            <div class="relative">
                {#if prefixIcon}
                    <div class="absolute left-2 top-2.5">
                        <Icon name={prefixIcon} classes="icon-{color}" />
                    </div>
                {/if}

                <input
                    {...$$restProps}
                    id={name}
                    {name}
                    on:input
                    bind:value
                    class="input-{color}  border text-sm rounded-lg block w-full p-2.5 {classes}"
                    class:input-error={hasError}
                    class:has-prefix-icon={!!prefixIcon}
                />
            </div>
        </div>
    </div>

    {#if typeof hasError == 'string' && hasError.length > 2}
        <div class="form-error">{hasError}</div>
    {/if}
</div>

<style lang="css">
    .has-prefix-icon {
        @apply pl-7;
    }

    .label-primary {
        @apply text-primary-900 dark:text-white;
    }
    .icon-primary {
        @apply text-gray-400 dark:text-primary-500;
    }
    .input-primary {
        @apply bg-primary-50 dark:bg-primary-800 border-primary-300 dark:border-primary-500 text-primary-900 dark:text-primary-100 focus:ring-primary-500 focus:border-primary-500 focus:outline-primary-500 placeholder:text-gray-400 dark:placeholder:text-primary-600;
    }

    .label-default {
        @apply text-gray-900 dark:text-white;
    }
    .icon-default {
        @apply text-gray-400 dark:text-gray-500;
    }
    .input-default {
        @apply bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-500 text-gray-900 dark:text-gray-100 focus:ring-gray-300 dark:focus:ring-gray-500 focus:border-gray-300 dark:focus:border-gray-600 focus:outline-gray-300 dark:focus:outline-gray-500 placeholder:text-gray-300 dark:placeholder:text-gray-600;
    }
</style>
