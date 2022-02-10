<template>
<Dialog @hide="clearForm" :visible="visible" @update:visible="$emit('update:visible', event)" :style="{width: '450px'}"
        :breakpoints="{'960px': '75vw', '640px': '100vw'}" header="User Details" :modal="true">
    <form class="grid formgrid p-fluid">
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" ref="name" label="Name" name="name" v-model="localUser.name"/>
        </div>
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" ref="email" label="Email" name="email" v-model="localUser.email" type="email"/>
        </div>
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" ref="password" component="Password" label="Password" v-model="localUser.password" name="password"/>
        </div>
        <div class="field mb-4 col-12">
            <FormField :displayErrors="displayErrors" ref="confirm_password" component="Password" label="Confirm Password" v-model="localUser.confirm_password"  name="confirm_password"/>
        </div>
    </form>
    <template #footer>
        <Button label="Cancel" icon="pi pi-times" class="p-button-text" @click="clearForm"/>
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
        user: Object,
        action: String
    },
    data(){
        return {
            showForm: this.visible,
            localUser: {},
            displayErrors: false
        }
    },
    updated(){
        this.localUser.id = this.user?.id
        this.localUser.name = this.user?.name
        this.localUser.email = this.user?.email
        this.localUser.password = ''
        this.localUser.confirm_password = ''
    },
    methods:{
        submit(){
            if (this.action === 'Create'){
                Inertia.post(
                    route('users.store'),
                    this.localUser,
                    {
                        onSuccess: () =>  this.clearForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }else if (this.action === 'Edit'){
                Inertia.patch(
                    route('users.update', this.localUser.id),
                    this.localUser,
                    {
                        onSuccess: () =>  this.clearForm(),
                        onFinish: () => this.displayErrors = true,
                    }
                );
            }
        },
        clearForm(){
            this.$emit('update:visible', false)
            this.displayErrors=false;
        }
    }
}
</script>
