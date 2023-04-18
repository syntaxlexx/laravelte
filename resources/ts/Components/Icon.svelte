<script lang="ts">
    export let name = 'bx bxs-pencil'
    export let classes: string = ''

    $: iconName = () => {
        switch (name) {
            case 'edit':
                return 'bx bx-pencil'
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
        }

        return `bx bx-${name}`
    }
</script>

<i class={iconName() + ' ' + classes} {...$$restProps} />
