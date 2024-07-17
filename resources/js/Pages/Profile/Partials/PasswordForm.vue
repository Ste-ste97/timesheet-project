<template>
    <form class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField v-model="form.current_password" autocomplete="current-password" component="InputText" label="Current Password" name="current_password" type="password"/>
        </div>
        <div class="field mb-4 col-12">
            <FormField v-model="form.new_password" autocomplete="new-password" component="Password" label="New Password" name="new_password"/>
        </div>
        <div class="field mb-4 col-12">
            <FormField v-model="form.confirm_new_password" autocomplete="new-password" component="Password" label="Confirm New Password" name="confirm_new_password" type="password"/>
        </div>

        <div class="col-12">
            <Button :disabled="form.processing" class="w-auto mt-3" label="Update Password" @click.prevent="saveProfile()"></Button>
        </div>
    </form>
</template>

<script>
import FormField from "@/Components/Primitives/FormField.vue"

export default {
    components : {
        FormField
    },
    data() {
        return {
            form : this.$inertia.form({
                current_password     : "",
                new_password         : "",
                confirm_new_password : "",
            })
        };
    },
    methods : {
        saveProfile() {
            this.$confirm.require({
                message : 'Are you sure you want to change your password?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.form.patch(this.route('profile.password'), {
                        preserveScroll : true,
                        onFinish       : () => this.form.reset('new_password', 'confirm_new_password'),
                        onSuccess      : () => {
                            this.form.current_password     = ""
                            this.form.new_password         = ""
                            this.form.confirm_new_password = ""
                        }
                    })
                },
                reject  : () => {
                }
            });
        },
    },
}
</script>
