<template>
    <Dialog :breakpoints="{'960px': '75vw', '640px': '100vw'}" :modal="true" :style="{width: '450px'}" :visible="visible"
            header="Timesheet Details" @show="initForm" @update:visible="$emit('update:visible', event)">
        <form class="grid formgrid p-fluid" @submit.prevent="submit">
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
    methods : {
        submit() {
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
               this.localTimesheet.id = this.timesheet.id;
               this.localTimesheet.hours = this.timesheet.hours;
            }
        },
        closeForm() {
            this.$emit('update:visible', false)
        }
    },
}
</script>
