<template>
<Dialog @show="initForm" :visible="visible" @update:visible="$emit('update:visible', event)" :style="{width: '450px'}"
        :breakpoints="{'960px': '75vw', '640px': '100vw'}" header="Role Details" :modal="true">
    <form @submit.prevent="submit" class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" label="Name" name="name" v-model="localRole.name"/>
        </div>
        <div class="field mb-4 col-12" v-has-permission="{props: $page.props, permissions: ['permissions.assign']}">
            <FormField :displayErrors="displayErrors" :options="permissions" optionValue="id" optionLabel="type" optionGroupLabel="name" :showToggleAll="false" optionGroupChildren="children" component="MultiSelect" label="Permissions" v-model="localRole.permissions"  name="roles"/>
        </div>
    </form>
    <template #footer>
        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="closeForm"/>
        <Button :label="action" icon="pi pi-check" class="p-button-text" @click="submit"/>
    </template>
</Dialog>
</template>

<script>
import FormField from "@/Components/FormField.vue"
import { Inertia } from '@inertiajs/inertia'

export default {
    emits: ['update:visible'],
    components:{
        FormField
    },
    props:{
        visible: Boolean,
        role: Object,
        permissions: Object,
        action: String
    },
    data(){
        return {
            showForm: this.visible,
            localRole: {},
            displayErrors: false,
        }
    },
    methods:{
        submit(){
            if (this.action === 'Create'){
                Inertia.post(
                    route('roles.store'),
                    this.localRole,
                    {
                        preserveScroll: true,
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }else if (this.action === 'Edit'){
                Inertia.patch(
                    route('roles.update', this.localRole.id),
                    this.localRole,
                    {
                        preserveScroll: true,
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }
        },
        initForm(){
            this.displayErrors = false;
            this.localRole.id = this.role?.id
            this.localRole.name = this.role?.name

            this.localRole.permissions = [];
            this.role?.permissions.map((permission) =>{
                this.localRole.permissions.push(permission.id);
            })
        },
        closeForm(){
            this.$emit('update:visible', false)
        }
    }
}
</script>
