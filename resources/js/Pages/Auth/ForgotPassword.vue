<template>

    <Head title="Reset Password"/>

    <div class="text-center mb-5">
        <img alt="Image" class="mb-3" height="50" src="/images/blocks/logos/hyper.svg">
        <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
        <span class="text-600 font-medium line-height-3">Remembered your password?</span>
        <Link class="font-medium no-underline ml-2 text-blue-500 cursor-pointer" href="/login">Login</Link>
    </div>

    <ValidationErrors class="mb-4"/>

    <Message v-if="status" severity="info">{{ status }}</Message>

    <form @submit.prevent="submit">
        <label class="block text-900 font-medium mb-2" for="email1">Email</label>
        <InputText id="email1" v-model="form.email" class="w-full mb-3" required type="text"/>

        <Button :disabled="form.processing" class="w-full" label="Reset Password" type="submit"></Button>
    </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default {
    layout : GuestLayout,

    components : {
        ValidationErrors,
        Head,
        Link
    },

    props : {
        status : String,
    },

    data() {
        return {
            form : this.$inertia.form({
                email : ''
            })
        }
    },

    methods : {
        submit() {
            this.form.post(this.route('password.email'))
        }
    }
}
</script>
