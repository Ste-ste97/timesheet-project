<template>
    <h3>
        Profile & Security
    </h3>
    <div class="surface-border border-round surface-section flex-auto">
        <div class="surface-section px-4 py-2">
            <div class="grid">
                <ConfirmDialog></ConfirmDialog>
                <div class="col-12">
                    <h3>Account Profile</h3>
                    <ProfileForm :countries="countries" :cities="cities"></ProfileForm>
                </div>
                <Divider />
                <div class="col-12">
                    <h3>Account Security</h3>
                    <PasswordForm></PasswordForm>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

import ProfileForm from "./Partials/ProfileForm.vue";
import PasswordForm from "./Partials/PasswordForm.vue";
import ValidationErrors from '@/Components/ValidationErrors.vue'

export default {
    layout: AuthenticatedLayout,
    props:{
        countries: Object,
        cities: Object
    },
    components: {
        Head,
        Link,
        AuthenticatedLayout,
        ProfileForm,
        PasswordForm,
        ValidationErrors
    },
};
</script>
