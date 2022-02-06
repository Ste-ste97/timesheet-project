<template>
<form>
    <div class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField component="InputText" label="Current Password" name="current_password" type="password" v-model="form.current_password" />
        </div>
        <div class="field mb-4 col-12">
            <FormField component="Password" label="New Password" name="new_password" type="password" v-model="form.new_password" />
        </div>
        <div class="field mb-4 col-12">
            <FormField component="Password" label="Confirm New Password" name="confirm_new_password" type="password" v-model="form.confirm_new_password" />
        </div>

        <div class="col-12">
            <Button @click="saveProfile()" label="Update Password" class="w-auto mt-3"></Button>
        </div>
    </div>
</form>
</template>

<script>
import FormField from "@/Components/FormField.vue"

export default {
    components:{
        FormField
    },
    data() {
        return {
            form: this.$inertia.form({
                current_password: "",
                new_password: "",
                confirm_new_password: "",
            })
        };
    },
    methods: {
        saveProfile() {
            this.$confirm.require({
                message: 'Are you sure you want to change your password?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    this.form.patch(this.route('profile.password'), {
                        preserveScroll: true,
                        onFinish: () => {},
                    })
                },
                reject: () => {
                }
            });
        },
    },
}
</script>
