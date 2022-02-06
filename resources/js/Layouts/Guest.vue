<template>
<div class="p-4 md:p-6 lg:p-8">
    <slot />
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
    @import '../../assets/styles/app/layout.scss';
</style>
