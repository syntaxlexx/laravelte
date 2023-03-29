<script lang="ts">
    import {inertia} from '@inertiajs/svelte'
</script>

<h2>About us</h2>

<a href="/" use:inertia>GoHome</a>
<a href={route('contact')} use:inertia>Contact</a>
