<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="Translation Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
            <div class="field mb-4 col-12">
                <FormField v-model="localTranslation.key" :displayErrors="displayErrors" autocomplete="key" label="Key" name="key"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTranslation.value" :displayErrors="displayErrors" autocomplete="value" label="Value" name="value" type="value"/>
            </div>
            <div class="field mb-4 col-12">
                <FormField v-model="localTranslation.language" :displayErrors="displayErrors" autocomplete="language" label="Language" name="language"/>
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
        visible     : Boolean,
        translation : Object,
        action      : String
    },
    data() {
        return {
            showForm         : this.visible,
            localTranslation : {},
            displayErrors    : false
        }
    },
    methods : {
        submit() {
            if (this.action === 'Create') {
                this.$inertia.post(
                    route('translations.store'),
                    this.localTranslation,
                    {
                        preserveScroll : true,
                        onSuccess      : () => this.closeForm(),
                        onFinish       : () => this.displayErrors = true,
                    }
                );
            } else
                if (this.action === 'Edit') {
                    this.$inertia.patch(
                        route('translations.update', this.localTranslation.id),
                        this.localTranslation,
                        {
                            preserveScroll : true,
                            onSuccess      : () => this.closeForm(),
                            onFinish       : () => this.displayErrors = true,
                        }
                    );
                }
        },
        initForm() {
            this.displayErrors             = false;
            this.localTranslation.id       = this.translation?.id
            this.localTranslation.key      = this.translation?.key
            this.localTranslation.value    = this.translation?.value
            this.localTranslation.language = this.translation?.language
        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    }
}
</script>
