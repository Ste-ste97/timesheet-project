<template>
    <form>
        <div class="grid formgrid p-fluid">
            <div class="field mb-4 col-12">
                <FormField v-model="form.name" label="Name" name="name"/>
            </div>
            <div class="field mb-4 col-12 md:col-6">
                <FormField v-model="form.email" label="Email" name="email"/>
            </div>
            <div class="field mb-4 col-12 md:col-6">
                <FormField v-model="form.country" :filter="true" :options="countries" component="Dropdown" label="Country" name="country" optionLabel="name" optionValue="id"
                           placeholder="Select a country"/>
            </div>
            <div class="field mb-4 col-12 md:col-6">
                <FormField v-model="form.city" :filter="true" :options="citiesOptions" component="Dropdown" label="City" name="city" optionLabel="name" optionValue="id" placeholder="Select a city"/>
            </div>
            <div class="field mb-4 col-12 md:col-6">
                <FormField v-model="form.state" label="State" name="state"/>
            </div>
            <div class="col-12">
                <Button :disabled="form.processing" class="w-auto mt-3" label="Save Changes" @click.prevent="saveProfile()"></Button>
            </div>
        </div>
    </form>
</template>

<script>
import FormField from "@/Components/FormField.vue"

export default {
    props      : {
        countries : Object,
        cities    : Object
    },
    components : {
        FormField
    },
    data() {
        return {
            form : this.$inertia.form({
                name    : this.$page.props.auth.user.name,
                email   : this.$page.props.auth.user.email,
                country : this.$page.props.auth.user.address?.country.id,
                city    : this.$page.props.auth.user.address?.city.id,
                state   : this.$page.props.auth.user.address?.state
            }),
        };
    },
    methods  : {
        saveProfile() {
            this.$confirm.require({
                message : 'Are you sure you want to update your profile?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.form.patch(this.route('profile.update'), {
                        preserveScroll : true,
                        onFinish       : () => {
                        },
                    })
                },
                reject  : () => {
                }
            });
        },
    },
    computed : {
        citiesOptions() {
            return this.cities.filter((city) => city.country.id == this.form.country);
        }
    }
}
</script>
