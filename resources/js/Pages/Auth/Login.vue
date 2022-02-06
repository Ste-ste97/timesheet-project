<template>

<Head title="Login" />

<div class="card">
    <div class="flex justify-content-center flex-wrap card-container yellow-container">
        <div class="surface-card p-4 shadow-2 border-round w-full md:w-8 xl:w-4">
            <div class="text-center mb-5">
                <img src="images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
                <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
                <span class="text-600 font-medium line-height-3">Don't have an account?</span>
                <Link href="/register" class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Create today!</Link>
            </div>

            <ValidationErrors class="mb-4" />

            <form>
                <label for="email" class="block text-900 font-medium mb-2">Email</label>
                <InputText id="email" v-model="form.email" type="text" class="w-full mb-3" />

                <label for="password" class="block text-900 font-medium mb-2">Password</label>
                <InputText id="password"  v-model="form.password" type="password" class="w-full mb-3" />

                <div class="flex align-items-center justify-content-between mb-6">
                    <div class="flex align-items-center">
                        <Checkbox id="rememberme1" :binary="true" v-model="form.remember" class="mr-2"></Checkbox>
                        <label for="rememberme1">Remember me</label>
                    </div>
                    <Link href="/forgot-password" class="font-medium no-underline ml-2 text-blue-500 text-right cursor-pointer">Forgot password?</Link>
                </div>

                <Button label="Sign In" @click.prevent="submit" icon="pi pi-user" class="w-full"></Button>
            </form>
        </div>
    </div>
</div>

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
        Link,
    },

    props: {
        canResetPassword: Boolean,
        status: String,
    },

    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember: false
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('login'), {
                onFinish: () => this.form.reset('password'),
            })
        }
    }
}
</script>
