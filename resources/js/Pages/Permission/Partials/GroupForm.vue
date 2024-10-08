<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="Group Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localGroup.name" :displayErrors="displayErrors" label="Group Name" name="name"/>
            </div>

            <div class="field mb-4 col-12">
                <FormField v-model="localGroup.guard_name" :displayErrors="displayErrors" label="Guard Name" name="guard_name"/>
            </div>
            <div v-if="action === 'Create'" class="field mb-4 col-12">
                <Checkbox v-model="isCRUD" :binary="true"/>
                Make default CRUD permissions.
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
        visible : Boolean,
        group   : Object,
        action  : String
    },
    data() {
        return {
            showForm      : this.visible,
            localGroup    : {},
            displayErrors : false,
            isCRUD        : true
        }
    },
    methods : {
        submit() {
            if (this.action === 'Create') {
                this.$inertia.post(
                    route('permissions.storeGroup'),
                    {
                        ...this.localGroup,
                        is_crud : this.isCRUD
                    },
                    {
                        preserveScroll : true,
                        onSuccess      : () => this.closeForm(),
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    this.$inertia.patch(
                        route('permissions.updateGroup', this.localGroup.id),
                        this.localGroup,
                        {
                            preserveScroll : true,
                            onSuccess      : () => this.closeForm(),
                            onFinish       : () => this.displayErrors = true,
                        }
                    );
                }
        },
        initForm() {
            this.displayErrors         = false;
            this.localGroup.id         = this.group?.id
            this.localGroup.name       = this.group?.name
            this.localGroup.guard_name = this.group?.guard_name ?? 'web'
        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    }
}
</script>
