<template>

<Head title="Reset Password" />

    <div class="text-center mb-5">
        <img src="images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
        <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
        <span class="text-600 font-medium line-height-3">Remembered your password?</span>
        <Link href="/login" class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Login</Link>
    </div>

    <ValidationErrors class="mb-4" />

    <Message v-if="status" severity="info">{{status}}</Message>

    <form @submit.prevent="submit">
        <label for="email1" class="block text-900 font-medium mb-2">Email</label>
        <InputText id="email1" v-model="form.email" type="text" class="w-full mb-3" required/>

        <Button type="submit" :disabled="form.processing" label="Reset Password" class="w-full"></Button>
    </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    layout: GuestLayout,

    components: {
        ValidationErrors,
        Head,
        Link
    },

    props: {
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
