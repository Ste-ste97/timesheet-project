<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '500px'}" :visible="visible"
            :header="'Client Details'" @show="initForm" @hide="closeForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localClient.name" :displayErrors="displayErrors" autocomplete="name" label="Name"
                           name="name" :isRequired="true"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="isPrivate" component="Boolean" :displayErrors="displayErrors" label="Private Company"
                           name="is_private" :isRequired="true"/>
            </div>

            <div v-has-permission="{props: $page.props, permissions: ['users.assign']}" class="field mb-4 col-12">
                <FormField v-model="localClient.users" :displayErrors="displayErrors" :filter="false" :options="users" component="MultiSelect" label="Users" name="users"
                           optionLabel="name" optionValue="id"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.email" :displayErrors="displayErrors" autocomplete="email" label="Email"
                           name="email" :isRequired="true"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.mobile_phone" :displayErrors="displayErrors" autocomplete="mobile_phone" label="Mobile Phone"
                           name="mobile_phone" :isRequired="true"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.landline_phone" :displayErrors="displayErrors" autocomplete="landline_phone" label="Landline Phone"
                           name="landline_phone"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.address" :displayErrors="displayErrors" autocomplete="address" label="Address"
                           name="address" component="Textarea"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.fax" :displayErrors="displayErrors" autocomplete="fax" label="Fax"
                           name="fax"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localClient.postal_code" :displayErrors="displayErrors" autocomplete="postal_code" label="Postal Code"
                           name="postal_code"/>
            </div>

            <p style="color: red;">* {{ __('The field is required') }}</p>
        </form>
        <template #footer>
            <Button class="p-button-text" icon="pi pi-times" label="Cancel" @click="closeForm"/>
            <Button :label="action" class="p-button-text" icon="pi pi-check" @click="submit"/>
        </template>
    </Dialog>
</template>

<script>
import FormField from "@/Components/Primitives/FormField.vue"
import DataTableMixins from '@/Components/Mixins/DataTableMixins.vue';

export default {
    emits      : ['update:visible'],
    components : {
        FormField
    },
    props      : {
        visible : Boolean,
        client  : Object,
        users   : Object,
        action  : String,
        fields  : Object,
    },
    mixins     : [DataTableMixins],
    data() {
        return {
            showForm      : this.visible,
            localClient   : {},
            displayErrors : false,
            isPrivate     : false,
        }
    },
    watch   : {
        isPrivate(oldValue, newValue) {
            if (oldValue !== newValue && this.isPrivate === true) {
                this.localClient.users = [];
            } else {
                this.localClient.users = this.users.map(user => user.id);
            }

        }
    },
    methods : {
        submit() {
            this.localClient.is_private = this.isPrivate ? 1 : 0;

            if (this.action === 'Create') {
                this.$inertia.post(
                    route('clients.store'),
                    this.localClient,
                    {
                        preserveScroll : true,
                        onSuccess      : () => {
                            this.closeForm();
                            this.$inertia.get(route('clients.index'))
                        },
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    this.$inertia.patch(
                        route('clients.update', this.localClient.id),
                        this.localClient,
                        {
                            preserveScroll : true,
                            onSuccess      : () => {
                                this.closeForm();
                                this.$inertia.get(route('clients.index'))
                            },
                            onFinish       : () => this.displayErrors = true
                        }
                    );
                }
        },
        initForm() {
            this.displayErrors = false;
            if (this.client) {
                Object.keys(this.client).forEach(key => {
                    if (key === 'users') {
                        this.localClient[key] = this.client[key].map(user => user.id);
                    } else {
                        this.localClient[key] = this.client[key];
                    }
                });
                this.isPrivate = this.client?.is_private === 1;
            } else {
                this.fields.forEach(key => {
                    if (key.field === 'users') {
                        this.localClient.users = this.users.map(user => user.id);
                        console.log(this.localClient[key]);
                    } else {
                        this.localClient[key] = null;
                    }
                });
            }

        },
        closeForm() {
            this.localClient = {};
            this.isPrivate   = false;
            this.$emit('update:visible', false)
        }
    }
}
</script>
