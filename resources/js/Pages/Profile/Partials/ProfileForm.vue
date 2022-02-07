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
            <FormField label="Country" name="country" component="Dropdown" v-model="form.country" :options="countries" :filter="true" optionLabel="name" optionValue="id" placeholder="Select a country" />
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <FormField label="City" name="city" component="Dropdown" v-model="form.city" :options="citiesOptions" :filter="true" optionLabel="name" optionValue="id" placeholder="Select a city" />
        </div>
        <div class="field mb-4 col-12 md:col-6">
            <FormField label="State" name="state" v-model="form.state"/>
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
    props:{
        countries: Object,
        cities: Object
    },
    components:{
        FormField
    },
    data() {
        return {
            form: this.$inertia.form({
                name: this.$page.props.auth.user.name,
                email: this.$page.props.auth.user.email,
                country: this.$page.props.auth.user.address?.country.id,
                city: this.$page.props.auth.user.address?.city.id,
                state: this.$page.props.auth.user.address?.state
            }),
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
    computed:{
        citiesOptions(){
            return this.cities.filter((city) => city.country.id == this.form.country);
        }
    }
}
</script>
