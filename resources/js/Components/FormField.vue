<template>
    <label :for="name" class="font-medium text-900">{{ label }}</label>
    <InputText v-if="component === 'InputText'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" />
    <Password v-else-if="component === 'Password'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" />
    <Dropdown v-else-if="component === 'Dropdown'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" />
    <MultiSelect v-else-if="component === 'MultiSelect'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" />
    <small v-if="$page.props.errors[name]" :id="name+'-help'" class="p-error">{{ $page.props.errors[name] }}</small>
</template>

<script>
export default {
    props:{
        label: String,
        name: String,
        component: {
            type: String,
            default: 'InputText'
        }
    }
}
</script>
