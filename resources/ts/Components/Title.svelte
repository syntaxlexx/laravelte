<script lang="ts">
    export let bgColor = 'bg-primary-50 dark:bg-primary-900'
</script>

<div class="relative mb-10">
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-primary-500" />
    </div>
    <div class="relative flex justify-start">
        <span class="pr-3 {bgColor} text-2xl font-bold text-primary-700 dark:text-primary-300">
            <slot />
        </span>
    </div>
</div>
