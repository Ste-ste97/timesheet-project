<template>
    <Head title="Confirm Password"/>

    <div class="text-center mb-5">
        This is a secure area of the application. Please confirm your password before continuing.
    </div>

    <ValidationErrors class="mb-4"/>
    <form>
        <label class="block text-900 font-medium mb-2" for="password">Password</label>
        <InputText id="password" v-model="form.password" class="w-full mb-3" type="password"/>
        <Button :disabled="form.processing" class="w-full" label="Reset Password" @click="submit"></Button>
    </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head} from '@inertiajs/inertia-vue3';

export default {
    layout : GuestLayout,

    components : {
        ValidationErrors,
        Head,
    },

    data() {
        return {
            form : this.$inertia.form({
                password : '',
            })
        }
    },

    methods : {
        submit() {
            this.form.post(this.route('password.confirm'), {
                onFinish : () => this.form.reset(),
            })
        }
    }
}
</script>
