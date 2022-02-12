<template>

<div class="card">
    <div class="relative card-container green-container">
        <div class="relative p-4 border-round " style="min-width: 100vw; min-height: 100vh;">
            <slot/>
        </div>
    </div>
</div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
};
</script>

<style lang="scss">
    @import '../../assets/styles/layout.scss';
</style>
