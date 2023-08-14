<template>

    <Head title="Login"/>

    <div class="text-center mb-5">
        <img alt="Image" class="mb-3" height="50" :src="appLogo">
        <div class="text-900 text-3xl font-medium mb-3">Two Factor Authentication</div>
        <div class="grid">
            <span class="col-12 text-600 font-medium line-height-3">Please enter the secret code to connect to this secure portal.</span>
            <span class="col-12 text-600 font-medium line-height-3">To request a new code: <a :class="countdown ? 'disabled' : ''" href="#" @click="generateCode()">{{ generateText }}</a></span>
        </div>
    </div>

    <ValidationErrors class="mb-4"/>
    <Message v-if="status" severity="info">{{ status }}</Message>

    <form @submit.prevent="submit">
        <label class="block text-900 font-medium mb-2" for="secret">Code</label>
        <InputText id="secret" v-model="form.secret" class="w-full mb-3" required type="text"/>

        <Button :disabled="form.processing" class="w-full" label="Confirm Code" type="submit"></Button>
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
            form      : this.$inertia.form({
                secret : ''
            }),
            countdown : 0,
            appLogo,
        }
    },
    computed : {
        generateText() {
            return this.countdown === 0 ? 'Click here' : `Please wait (${this.countdown})`;
        }
    },
    watch    : {
        countdown(value) {
            if (value > 0) {
                setTimeout(() => {
                    this.countdown--;
                }, 1000);
            }
        }
    },
    methods  : {
        submit() {
            this.form.post(this.route('2FA.validateSession'), {})
        },
        generateCode() {
            if (this.countdown > 0) {
                return;
            }
            this.$inertia.post(this.route('2FA.generateCode'))
            this.countdown = 60;
        }
    }
}
</script>
<style>
a.disabled {
    pointer-events : none;
    cursor         : default;
}
</style>