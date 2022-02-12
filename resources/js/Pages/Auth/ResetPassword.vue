<template>
    <Head title="Reset Password" />

    <div class="flex justify-content-center flex-wrap card-container yellow-container">
        <div class="surface-card p-4 shadow-2 border-round w-full md:w-8 xl:w-4">
            <div class="text-center mb-5">
                <img src="/images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
                <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
                <span class="text-600 font-medium line-height-3">Already registered?</span>
                <Link href="/login" class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Login</Link>
            </div>

            <form @submit.prevent="submit" class="grid formgrid p-fluid">
                <div class="field mb-4 col-12">
                    <FormField label="Email" name="email" v-model="form.email" type="text" class="w-full" />
                </div>

                <div class="field mb-4 col-12">
                    <FormField component="Password" label="Password" name="password" v-model="form.password" />
                </div>

                <div class="field mb-4 col-12">
                    <FormField label="Confirm Password" name="password_confirm" v-model="form.password_confirmation" type="password" />
                </div>

                <Button label="Reset Password" :disabled="form.processing" type="submit" class="w-full"></Button>
            </form>
        </div>
    </div>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';
import FormField from "@/Components/FormField.vue"

export default {
    layout: GuestLayout,

    components: {
        ValidationErrors,
        Head,
        Link,
        FormField
    },

    props: {
        email: String,
        token: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                token: this.token,
                email: this.email,
                password: '',
                password_confirmation: '',
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.update'), {
                onFinish: () => this.form.reset('password', 'password_confirmation'),
            })
        }
    }
}
</script>
