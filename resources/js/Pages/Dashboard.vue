<template>
    <div class="surface-border border-round surface-section flex-auto">
        <div class="surface-section px-4 py-4">
            <div class="grid">You're logged in!</div>
        </div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    layout: AuthenticatedLayout,
    components: {
        AuthenticatedLayout,
        Head,
    },
};
</script>
