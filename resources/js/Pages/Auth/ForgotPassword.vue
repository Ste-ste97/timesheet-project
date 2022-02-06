<template>

<Head title="Reset Password" />

<div class="card">
    <div class="flex justify-content-center flex-wrap card-container yellow-container">
        <div class="surface-card p-4 shadow-2 border-round w-full md:w-8 xl:w-4">
            <div class="text-center mb-5">
                <img src="images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
                <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
                <span class="text-600 font-medium line-height-3">Remembered your password?</span>
                <a href="/login" class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Login</a>
            </div>

            <ValidationErrors class="mb-4" />

            <Message v-if="status" severity="info">{{status}}</Message>

            <form>
                <label for="email1" class="block text-900 font-medium mb-2">Email</label>
                <InputText id="email1" v-model="form.email" type="text" class="w-full mb-3" />

                <Button @click="submit" label="Reset Password" class="w-full"></Button>
            </form>
        </div>
    </div>
</div>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import { Head } from '@inertiajs/inertia-vue3';

export default {
    layout: GuestLayout,

    components: {
        ValidationErrors,
        Head,
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
