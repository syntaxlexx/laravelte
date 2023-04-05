<script lang="ts">
    export let name = 'bx bxs-pencil'

    $: iconName = () => {
        switch (name) {
            case 'edit':
                return 'bx bxs-pencil'
        }

        return name
    }
</script>

<i class={iconName()} />
