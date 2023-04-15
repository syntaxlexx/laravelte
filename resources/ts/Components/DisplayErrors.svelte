<script lang="ts">
    import { getValidationErrorMessages } from '@/helpers'

    export let errors: null | string | string[] = null
    export let title: null | string = null

    $: formatedErrors = errors != null ? getValidationErrorMessages(errors) : null
</script>

{#if formatedErrors}
    <div class="border-l-4 bg-red-100 dark:bg-red-800 border-red-300 dark:border-red-600 rounded-r-lg p-4 my-2">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg
                    class="h-5 w-5 text-red-700 dark:text-red-300"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                >
                    <path
                        fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"
                    />
                </svg>
            </div>
            <div class="ml-3">
                {#if title}
                    <p class="text-sm mb-1 text-red-800 dark:text-red-200 underline underline-offset-4">
                        {title}
                    </p>
                {/if}
                {#each formatedErrors as item}
                    <p class="text-sm text-red-800 dark:text-red-200">{item}</p>
                {/each}
            </div>
        </div>
    </div>
{/if}
