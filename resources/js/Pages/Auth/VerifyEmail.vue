<template>
    <Head title="Email Verification"/>

    <div class="mb-4 text-sm text-gray-600">
        Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you
        another.
    </div>

    <div v-if="verificationLinkSent" class="mb-4 font-medium text-sm text-green-600">
        A new verification link has been sent to the email address you provided during registration.
    </div>

    <form @submit.prevent="submit">
        <div class="mt-4 flex items-center justify-between">
            <Button :disabled="form.processing" class="w-full" label="Resend Verification Email" type="submit"></Button>

            <Link :href="route('logout')" as="button" class="underline text-sm text-gray-600 hover:text-gray-900" method="post">Log Out</Link>
        </div>
    </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import {Head, Link} from '@inertiajs/vue3';

export default {
    layout : GuestLayout,

    components : {
        Head,
        Link,
    },

    props : {
        status : String,
    },

    data() {
        return {
            form : this.$inertia.form()
        }
    },

    methods : {
        submit() {
            this.form.post(this.route('verification.send'))
        },
    },

    computed : {
        verificationLinkSent() {
            return this.status === 'verification-link-sent';
        }
    }
}
</script>
