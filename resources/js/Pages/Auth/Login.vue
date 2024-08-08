<template>

    <Head title="Login"/>

    <div class="text-center mb-5">
        <img alt="Image" class="mb-3" height="50" :src="appLogo">
        <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
<!--        <div class="grid">-->
<!--            <span class="col-12 text-600 font-medium line-height-3">Don't have an account?</span>-->
<!--            <Link class="col-12 font-medium no-underline ml-2 text-blue-500 cursor-pointer" href="/register">Create today!</Link>-->
<!--        </div>-->
    </div>

    <ValidationErrors class="mb-4"/>
    <Message v-if="status" severity="info">{{ status }}</Message>

    <form @submit.prevent="submit">
        <label class="block text-900 font-medium mb-2" for="email">Email</label>
        <InputText id="email" v-model="form.email" class="w-full mb-3" required type="text"/>

        <label class="block text-900 font-medium mb-2" for="password">Password</label>
        <InputText id="password" v-model="form.password" class="w-full mb-3" required type="password"/>

        <div class="grid">
            <div class="col-12 md:col-6">
                <Checkbox id="rememberme1" v-model="form.remember" :binary="true" class="mr-2"></Checkbox>
                <label for="rememberme1">Remember me</label>
            </div>
            <Link class="col-12 md:col-6 font-medium no-underline md:text-right text-blue-500 cursor-pointer" href="/forgot-password">Forgot password?</Link>
        </div>

        <Button :disabled="form.processing" class="w-full" icon="pi pi-user" label="Sign In" type="submit"></Button>
    </form>

</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/vue3';
import appLogo from '/resources/images/blocks/logos/hyper.svg';

export default {
    layout : GuestLayout,

    components : {
        ValidationErrors,
        Head,
        Link,
    },

    props : {
        canResetPassword : Boolean,
        status           : String,
    },

    data() {
        return {
            form : this.$inertia.form({
                email    : '',
                password : '',
                remember : false
            }),
            appLogo
        }
    },

    methods : {
        submit() {
            this.form.post(this.route('login'), {
                onFinish : () => this.form.reset('password'),
            })
        }
    }
}
</script>
