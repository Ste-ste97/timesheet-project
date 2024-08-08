<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="User Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localUser.name" :displayErrors="displayErrors" autocomplete="name" label="Name" name="name"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localUser.email" :displayErrors="displayErrors" autocomplete="email" label="Email" name="email" type="email"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localUser.password" :displayErrors="displayErrors" autocomplete="new-password" component="Password" label="Password" name="password"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localUser.confirm_password" :displayErrors="displayErrors" autocomplete="new-password" component="Password" label="Confirm Password" name="confirm_password"/>
            </div>
            <div v-has-permission="{props: $page.props, permissions: ['roles.assign']}" class="field mb-4 col-12">
                <FormField v-model="localUser.roles" :displayErrors="displayErrors" :filter="false" :options="roles" component="MultiSelect" label="Roles" name="roles" optionLabel="name"
                           optionValue="id"/>
            </div>

            <div v-has-permission="{props: $page.props, permissions: ['companies.assign']}" class="field mb-4 col-12">
                <FormField v-model="localUser.companies" :displayErrors="displayErrors" :filter="false" :options="companies" component="MultiSelect" label="Companies" name="companies"
                           optionLabel="name" optionValue="id"/>
            </div>

            <div v-has-permission="{props: $page.props, permissions: ['services.assign']}" class="field mb-4 col-12">
                <FormField v-model="localUser.services" :displayErrors="displayErrors" :filter="false" :options="services" component="MultiSelect" label="Services" name="services"
                           optionLabel="name" optionValue="id"/>
            </div>

            <div v-has-permission="{props: $page.props, permissions: ['services.edit']}" class="field mb-4 col-12">
                <div v-for="(index) in localUser?.servicesDetails?.length" :key="index">
                    <FormField v-model="localUser.servicesDetails[index-1].cost_per_hour" :displayErrors="displayErrors" :label="localUser?.servicesDetails[index-1].name" name="service.cost_per_hour" component="Number"
                               mode="currency" currency="EUR"/>
                </div>
            </div>
        </form>
        <template #footer>
            <Button class="p-button-text" icon="pi pi-times" label="Cancel" @click="closeForm"/>
            <Button :label="action" class="p-button-text" icon="pi pi-check" @click="submit"/>
        </template>
    </Dialog>
</template>

<script>
import FormField from "@/Components/Primitives/FormField.vue"

export default {
    emits      : ['update:visible'],
    components : {
        FormField
    },
    props      : {
        visible   : Boolean,
        user      : Object,
        roles     : Object,
        companies : Object,
        services  : Object,
        action    : String
    },
    data() {
        return {
            showForm      : this.visible,
            localUser     : {},
            displayErrors : false,
            afterInit     : false
        }
    },
    watch: {
        'localUser.services': {
            handler(newServices, oldServices) {
                // Find removed services
                    const removedServices = oldServices?.filter(serviceId => !newServices.includes(serviceId));

                // Find added services
                const addedServices = newServices?.filter(serviceId => !oldServices?.includes(serviceId));

                // Remove services from servicesDetails
                this.localUser.servicesDetails = this.localUser.servicesDetails.filter(serviceDetail => !removedServices?.includes(serviceDetail.id));

                // Add new services to  `servicesDetails`
                addedServices.forEach(serviceId => {
                    //check if exist service in  `servicesDetails`
                    const exists = this.localUser.servicesDetails.some(serviceDetail => serviceDetail.id === serviceId);

                    if (!exists) {
                        const service = this.services.find(s => s.id === serviceId);
                        if (service) {
                            this.localUser.servicesDetails.push({
                                id: service.id,
                                name: service.name,
                                cost_per_hour: this.isAdmin? 50 : 20
                            });
                        }
                    }
                });
            },
            deep: true
        }
    },
    computed: {
       isAdmin() {
            return this.user?.is_admin === 1;
        }
    },
    methods : {
        submit() {
            if (this.action === 'Create') {
                this.$inertia.post(
                    route('users.store'),
                    this.localUser,
                    {
                        preserveScroll : true,
                        onSuccess      : () => this.closeForm(),
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    console.log(this.localUser)
                    this.$inertia.patch(
                        route('users.update', this.localUser.id),
                        this.localUser,
                        {
                            preserveScroll : true,
                            onSuccess      : () => this.closeForm(),
                            onFinish       : () => this.displayErrors = true,
                        }
                    );
                }
        },
        initForm() {
            this.displayErrors   = false;
            this.localUser.id    = this.user?.id
            this.localUser.name  = this.user?.name
            this.localUser.email = this.user?.email

            this.localUser.password         = ''
            this.localUser.confirm_password = ''

            const roles = [];
            this.user?.roles.map((role) => {
                roles.push(role.id);
            })

            this.localUser.roles = roles;

            const companies = [];
            this.user?.companies.map((company) => {
                companies.push(company.id);
            })

            this.localUser.companies = companies;

            const serviceIds = [];
            this.user?.services.forEach((service) => {
                serviceIds.push(service.id);
            });

            this.localUser.services = serviceIds;

            const servicesDetails = [];
            this.user?.services.forEach((service) => {
                servicesDetails.push({
                    id            : service.id,
                    name          : service.name,
                    cost_per_hour : parseFloat(service.pivot.cost_per_hour)
                });
            });

            this.localUser.servicesDetails = servicesDetails;
        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    }
}
</script>
