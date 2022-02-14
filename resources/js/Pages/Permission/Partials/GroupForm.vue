<template>
<Dialog @show="initForm" :visible="visible" @update:visible="$emit('update:visible', event)" :style="{width: '450px'}"
        :breakpoints="{'960px': '75vw', '640px': '100vw'}" header="Group Details" :modal="true">
    <form @submit.prevent="submit" class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" label="Group Name" name="name" v-model="localGroup.name"/>
        </div>

        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" label="Guard Name" name="guard_name" v-model="localGroup.guard_name"/>
        </div>
        <div class="field mb-4 col-12" v-if="action === 'Create'">
            <Checkbox v-model="isCRUD" :binary="true" /> Make default CRUD permissions.
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
        group: Object,
        action: String
    },
    data(){
        return {
            showForm: this.visible,
            localGroup: {},
            displayErrors: false,
            isCRUD: true
        }
    },
    methods:{
        submit(){
            if (this.action === 'Create'){
                Inertia.post(
                    route('permissions.storeGroup'),
                    {...this.localGroup,
                        is_crud: this.isCRUD},
                    {
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }else if (this.action === 'Edit'){
                Inertia.patch(
                    route('permissions.updateGroup', this.localGroup.id),
                    this.localGroup,
                    {
                        onSuccess: () =>  this.closeForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }
        },
        initForm(){
            this.displayErrors = false;
            this.localGroup.id = this.group?.id
            this.localGroup.name = this.group?.name
            this.localGroup.guard_name = this.group?.guard_name ?? 'web'
        },
        closeForm(){
            this.$emit('update:visible', false)
        }
    }
}
</script>
