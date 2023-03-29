<script lang="ts">
    import {inertia} from '@inertiajs/svelte'
</script>

<h2>Contact us</h2>

<a href="/" use:inertia>Go Home</a>
<a href={route('about')} use:inertia>About</a>
