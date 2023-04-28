<script lang="ts">
    export let name = 'bx bxs-pencil'
    export let classes: string = ''

    type IconSize = 'n' | 'sm' | 'lg' | 'xl'
    export let size: IconSize = 'n'

    $: iconName = () => {
        switch (name) {
            case 'email':
                return 'bx bx-envelope'
            case 'edit':
                return 'bx bx-pencil'
            case 'add':
                return 'bx bx-plus'
            case 'delete':
                return 'bx bx-trash-alt'
            case 'email':
                return 'bx bx-envelope'
            case 'phone':
                return 'bx bx-phone'
            case 'deactivate':
                return 'bx bx-error-circle'
            case 'check':
                return 'bx bx-check'
            case 'star':
                return 'bx bxs-star'
            case 'star-empty':
                return 'bx bx-star'
            case 'arrow-up':
                return 'bx bx-up-arrow-alt'
            case 'arrow-down':
                return 'bx bx-down-arrow-alt'
            case 'waiting':
                return 'bx bx-time-five'
            case 'clear':
                return 'bx bx-x'
            case 'google':
                return 'bx bxl-google'
            case 'facebook':
                return 'bx bxl-facebook-circle'
            case 'verified':
                return 'bx bx-badge-check'
            case 'view':
                return 'bx bx-chevron-right'
            case 'reports':
                return 'bx bx-bar-chart-alt-2'
        }

        return `bx bx-${name}`
    }
</script>

<i class={`${iconName()} icon-${size} ${classes}`} {...$$restProps} />

<style lang="css">
    .icon-n {
        @apply text-[18px];
    }
    .icon-lg {
        @apply text-[22px];
    }
    .icon-xl {
        @apply text-[28px];
    }
    .icon-sm {
        @apply text-[14px];
    }
</style>
