<template>
    <div v-has-permission="{props: $page.props,
                                        permissions: ['users.view']}" class="card">
        <div class="grid">{{__('You have access to view users.')}}</div>
    </div>

    <div v-has-role="{props: $page.props,
                                    roles: ['admin']}" class="card">
        <div class="grid">You have access to admin role.</div>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import {Head} from "@inertiajs/vue3";

export default {
    layout     : AuthenticatedLayout,
    components : {
        AuthenticatedLayout,
        Head,
    },
};
</script>
