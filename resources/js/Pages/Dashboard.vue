<template>
    <div class="card" v-has-permission="{props: $page.props,
                                        permissions: ['users.view']}">
        <div class="grid">You have access to view users.</div>
    </div>

    <div class="card" v-has-role="{props: $page.props,
                                    roles: ['admin']}">
        <div class="grid">You have access to admin role.</div>
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
