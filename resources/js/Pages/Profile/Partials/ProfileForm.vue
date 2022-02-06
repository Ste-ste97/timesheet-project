<template>
<form>
    <div class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField label="Name" name="name" v-model="form.name"/>
        </div>
        <div class="field mb-4 col-12">
            <label for="avatar" class="font-medium text-900">Avatar</label>
            <div class="flex align-items-center">
                <img src="images/blocks/avatars/circle/avatar-f-4.png" class="mr-4" />
                <FileUpload mode="basic" name="avatar" url="./upload.php" accept="image/*" :maxFileSize="1000000" class="p-button-outlined p-button-plain" chooseLabel="Upload Image"></FileUpload>
            </div>
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <FormField label="Email" name="email" v-model="form.email"/>
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <FormField label="Country" name="country" component="Dropdown" v-model="form.country" :options="countries" :filter="true" optionLabel="name" optionValue="code" placeholder="Select a country" />
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <label for="city" class="font-medium text-900">City</label>
            <InputText id="city" type="text" />
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <label for="state" class="font-medium text-900">State</label>
            <InputText id="state" type="text" />
        </div>
        <div class="col-12">
            <Button @click="saveProfile()" label="Save Changes" class="w-auto mt-3"></Button>
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
                name: this.$page.props.auth.user.name,
                email: this.$page.props.auth.user.email,
                country: ""
            }),
            countries: [
                {name: 'Cyprus', code: 'CY'},
                {name: 'Greece', code: 'GR'},
            ],
        };
    },
    methods: {
        saveProfile() {
            this.$confirm.require({
                message: 'Are you sure you want to update your profile?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    this.form.patch(this.route('profile.update'), {
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
