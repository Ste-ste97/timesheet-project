<template>
    <div class="flex justify-content-center align-items-center" style="min-height: 100vh">
        <div class="surface-card p-4 shadow-2 border-round w-full md:w-8 xl:w-4">
            <slot/>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    components : {
        Link,
    },
};
</script>

<style lang="scss">
@import '../../assets/styles/layout.scss';
</style>
