<template>
    <div class="card">
        <div class="grid">
            <div class="col-12">
                <h5>Account Profile</h5>
                <ProfileForm :cities="cities" :countries="countries"></ProfileForm>
            </div>
            <Divider/>
            <div class="col-12">
                <h5>Account Security</h5>
                <PasswordForm></PasswordForm>
            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";

import ProfileForm from "./Partials/ProfileForm.vue";
import PasswordForm from "./Partials/PasswordForm.vue";
import ValidationErrors from '@/Components/ValidationErrors.vue'

export default {
    layout     : AuthenticatedLayout,
    props      : {
        countries : Object,
        cities    : Object
    },
    components : {
        Head,
        Link,
        AuthenticatedLayout,
        ProfileForm,
        PasswordForm,
        ValidationErrors
    },
};
</script>
