<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="Role Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localRole.name" :displayErrors="displayErrors" label="Name" name="name"/>
            </div>
            <div v-has-permission="{props: $page.props, permissions: ['permissions.assign']}" class="field mb-4 col-12">
                <FormField v-model="localRole.permissions" :displayErrors="displayErrors" :options="permissions" :showToggleAll="false" component="MultiSelect" label="Permissions" name="roles"
                           optionGroupChildren="children" optionGroupLabel="name" optionLabel="type" optionValue="id"/>
            </div>
        </form>
        <template #footer>
            <Button class="p-button-text" icon="pi pi-times" label="Cancel" @click="closeForm"/>
            <Button :label="action" class="p-button-text" icon="pi pi-check" @click="submit"/>
        </template>
    </Dialog>
</template>

<script>
import FormField from "@/Components/FormField.vue"

export default {
    emits      : ['update:visible'],
    components : {
        FormField
    },
    props      : {
        visible     : Boolean,
        role        : Object,
        permissions : Object,
        action      : String
    },
    data() {
        return {
            showForm      : this.visible,
            localRole     : {},
            displayErrors : false,
        }
    },
    methods : {
        submit() {
            if (this.action === 'Create') {
                this.$inertia.post(
                    route('roles.store'),
                    this.localRole,
                    {
                        preserveScroll : true,
                        onSuccess      : () => this.closeForm(),
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    this.$inertia.patch(
                        route('roles.update', this.localRole.id),
                        this.localRole,
                        {
                            preserveScroll : true,
                            onSuccess      : () => this.closeForm(),
                            onFinish       : () => this.displayErrors = true,
                        }
                    );
                }
        },
        initForm() {
            this.displayErrors  = false;
            this.localRole.id   = this.role?.id
            this.localRole.name = this.role?.name

            this.localRole.permissions = [];
            this.role?.permissions.map((permission) => {
                this.localRole.permissions.push(permission.id);
            })
        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    }
}
</script>
