<template>
<Dialog @hide="clearForm" @show="initForm" :visible="visible" @update:visible="$emit('update:visible', event)" :style="{width: '450px'}"
        :breakpoints="{'960px': '75vw', '640px': '100vw'}" header="Role Details" :modal="true">
    <form class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" ref="name" label="Name" name="name" v-model="localRole.name"/>
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
        action: String
    },
    data(){
        return {
            showForm: this.visible,
            localRole: {},
            displayErrors: false
        }
    },
    methods:{
        submit(){
            if (this.action === 'Create'){
                Inertia.post(
                    route('roles.store'),
                    this.localRole,
                    {
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }else if (this.action === 'Edit'){
                Inertia.patch(
                    route('roles.update', this.localRole.id),
                    this.localRole,
                    {
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
        },
        closeForm(){
            this.$emit('update:visible', false)
        }
    }
}
</script>
