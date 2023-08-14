<template>
    <Head title="Reset Password"/>

    <div class="text-center mb-5">
        <img alt="Image" class="mb-3" height="50" :src="appLogo">
        <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
        <span class="text-600 font-medium line-height-3">Already registered?</span>
        <Link class="font-medium no-underline ml-2 text-blue-500 cursor-pointer" href="/login">Login</Link>
    </div>

    <form class="grid formgrid p-fluid" @submit.prevent="submit">
        <div class="field mb-4 col-12">
            <FormField v-model="form.email" class="w-full" label="Email" name="email" type="text"/>
        </div>

        <div class="field mb-4 col-12">
            <FormField v-model="form.password" component="Password" label="Password" name="password"/>
        </div>

        <div class="field mb-4 col-12">
            <FormField v-model="form.password_confirmation" label="Confirm Password" name="password_confirm" type="password"/>
        </div>

        <Button :disabled="form.processing" class="w-full" label="Reset Password" type="submit"></Button>
    </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/vue3';
import FormField from "@/Components/FormField.vue"
import appLogo from '/resources/images/blocks/logos/hyper.svg';

export default {
    layout : GuestLayout,

    components : {
        ValidationErrors,
        Head,
        Link,
        FormField
    },

    props : {
        email : String,
        token : String,
    },

    data() {
        return {
            form : this.$inertia.form({
                token                 : this.token,
                email                 : this.email,
                password              : '',
                password_confirmation : '',
            }),
            appLogo,
        }
    },

    methods : {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish : () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
