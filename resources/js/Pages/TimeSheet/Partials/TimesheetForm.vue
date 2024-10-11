<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="Timesheet Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localTimesheet.userId" optionLabel="name" optionValue="id" :displayErrors="displayErrors" label="Users" name="userId" :options="users"
                           component="Dropdown"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTimesheet.clientId" optionLabel="name" optionValue="id" :displayErrors="displayErrors" label="Clients" name="clientId" :options="clients"
                           component="Dropdown"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTimesheet.serviceId" optionLabel="name" optionValue="id" :displayErrors="displayErrors" label="Services" name="serviceId" :options="services"
                           component="Dropdown"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTimesheet.date" :displayErrors="displayErrors" autocomplete="date" component="Calendar" label="Date of Timesheet" name="date" dateFormat="dd/mm/yy"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTimesheet.hours" :displayErrors="displayErrors" label="Hours" name="hours"/>
            </div>
        </form>
        <template #footer>
            <Button class="p-button-text" icon="pi pi-times" label="Cancel" @click="closeForm"/>
            <Button :label="action" class="p-button-text" icon="pi pi-check" @click="submit"/>
        </template>
    </Dialog>
</template>

<script>
import FormField from '@/Components/Primitives/FormField.vue';

export default {
    emits      : ['update:visible'],
    components : {
        FormField
    },
    props      : {
        visible   : Boolean,
        timesheet : Object,
        action    : String,
    },
    data() {
        return {
            showForm       : this.visible,
            localTimesheet : {},
            displayErrors  : false,
        }
    },
    computed : {
        services() {
            return Object.values(this.$page.props.services);
        },
        users() {
            if (this.auth.is_admin !== 1) return [this.auth];
            return Object.values(this.$page.props.users);
        },
        clients() {
            return Object.values(this.$page.props.clients);
        },
        auth() {
            return this.$page.props.auth.user;
        }
    },
    methods  : {
        submit() {
            if (this.action === 'Create') {
                this.$inertia.post(
                    route('timesheets.store'),
                    this.localTimesheet,
                    {
                        preserveScroll : true,
                        onSuccess      : () => {
                            this.closeForm();
                            this.$inertia.get(route('timesheets.index'));
                        },
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    this.$inertia.patch(
                        route('timesheets.update', this.localTimesheet.id),
                        this.localTimesheet,
                        {
                            preserveScroll : true,
                            onSuccess      : () => {
                                this.closeForm();
                                this.$inertia.get(route('timesheets.index'));
                            },
                            onFinish       : () => this.displayErrors = true
                        }
                    );
                }
        },

        initForm() {
            this.displayErrors = false;
            if (this.timesheet) {
                this.localTimesheet.id        = this.timesheet.id;
                this.localTimesheet.userId    = this.timesheet.user_id;
                this.localTimesheet.userName  = this.timesheet.user.name;
                this.localTimesheet.clientId = this.timesheet.client_id;
                this.localTimesheet.serviceId = this.timesheet.service_id;
                this.localTimesheet.date      = new Intl.DateTimeFormat('en-US').format(new Date(this.timesheet.date));
                this.localTimesheet.hours     = this.timesheet.hours;
            }

        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    },
}
</script>
