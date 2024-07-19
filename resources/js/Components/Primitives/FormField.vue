<template>
    <div :class="labelClass">
        <label :for="name">
            <b v-if="boldLabel">{{ boldLabel }}</b>
            {{ label }}
            <span v-if="isRequired" class="mr-2" style="color: red;">*</span>
            <i v-if="hasInfo" class="pi pi-info-circle" v-tooltip="infoMessage" style="font-size: 15px;"></i>
        </label>
    </div>

    <div :class="inputClass">
        <InputText v-if="component === 'InputText'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <Password v-else-if="component === 'Password'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs">
            <template #header>
                <h3>Pick a password</h3>
            </template>
            <template #footer>
                <Divider/>
                <p class="mt-2">Suggestions</p>
                <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                    <li>At least one lowercase</li>
                    <li>At least one uppercase</li>
                    <li>At least one numeric</li>
                    <li>Minimum 8 characters</li>
                </ul>
            </template>
        </Password>
        <Dropdown v-else-if="component === 'Dropdown'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <MultiSelect v-else-if="component === 'MultiSelect'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <InputNumber v-else-if="component==='Number'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <Textarea v-else-if="component==='Textarea'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs" style="resize: none;"/>
        <FileUpload v-else-if="component === 'File'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" style="width:130px;" v-bind="$attrs"/>
        <Calendar v-else-if="component === 'Calendar'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" locale="en-GB" v-bind="$attrs"/>
        <InputSwitch v-else-if="component === 'Boolean'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <Checkbox v-else-if="component === 'Checkbox'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        <InputGroup v-else-if="component === 'Telephone'" :style="$attrs.style">
            <InputGroupAddon v-if="dialCall">{{ dialCall }}</InputGroupAddon>
            <InputText :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>
        </InputGroup>
        <CustomFileUpload v-else-if="component === 'CustomFileUpload'" :id="name" :class="shouldDisplayErrors ? 'p-invalid' : ''" v-bind="$attrs"/>

        <small v-if="shouldDisplayErrors" :id="name+'-help'" class="p-error">{{ errorMessage }}</small>
    </div>
</template>

<script>
import CustomFileUpload from '@/Components/CustomFileUpload.vue';

export default {
    components : {CustomFileUpload},
    props    : {
        label          : String,
        name           : String,
        displayErrors  : {
            type    : Boolean,
            default : true
        },
        component      : {
            type    : String,
            default : 'InputText'
        },
        isRequired     : {
            type    : Boolean,
            default : false
        },
        hasInfo        : {
            type    : Boolean,
            default : false
        },
        infoMessage    : {
            type    : String,
            default : 'Description of the field.'
        },
        customLayout   : {
            type    : Boolean,
            default : false
        },
        boldLabel      : {
            type    : String,
            default : ''
        },
        dialCall       : {
            type    : String,
            default : '+357'
        },
        validationType : {
            type    : String,
            default : 'backend' // 'frontend' or 'backend'
        },
        frontEndErrors : {
            type    : Object,
            default : () => ({})
        }
    },
    computed : {
        shouldDisplayErrors() {
            if (this.validationType === 'frontend') {
                return this.frontEndErrors[this.name] && this.displayErrors;
            } else {
                return this.$page.props.errors[this.name] && this.displayErrors;
            }
        },
        errorMessage() {
            if (this.validationType === 'frontend') {
                return this.frontEndErrors[this.name];
            } else {
                return this.$page.props.errors[this.name];
            }
        },
        labelClass() {
            return this.customLayout ? 'col-12 lg:col-6' : 'font-medium text-900 block w-full';
        },
        inputClass() {
            return this.customLayout ? 'col-12 lg:col-6 input-container' : 'mt-2';
        },
    }
}
</script>

<style scoped>
.input-container {
    display: flex;
    flex-direction: column;
}
</style>
