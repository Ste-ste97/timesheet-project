<template>
<Dialog @show="initForm" :visible="visible" @update:visible="$emit('update:visible', event)" :style="{width: '450px'}"
        :breakpoints="{'960px': '75vw', '640px': '100vw'}" header="Permission Details" :modal="true">
    <form @submit.prevent="submit" class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" label="Type" name="type" v-model="localPermission.type"/>
        </div>

        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" label="Description" name="description" v-model="localPermission.description"/>
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
        action: String,
        group: Object,
        permission: Object
    },
    data(){
        return {
            showForm: this.visible,
            localPermission: {},
            displayErrors: false,
        }
    },
    methods:{
        submit(){
            if (this.action === 'Create'){
                Inertia.post(
                    route('permissions.store'),
                    {...this.localPermission,
                        group: this.group.id
                    },
                    {
                        preserveScroll: true,
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }else if (this.action === 'Edit'){
                Inertia.patch(
                    route('permissions.update', this.localPermission.id),
                    this.localPermission,
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
            this.localPermission.id = this.permission?.id
            this.localPermission.type = this.permission?.type
            this.localPermission.description = this.permission?.description

        },
        closeForm(){
            this.$emit('update:visible', false)
        }
    }
}
</script>
