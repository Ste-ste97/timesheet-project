<template>
    <label :for="name" class="font-medium text-900">{{ label }}</label>
    <InputText v-if="component === 'InputText'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" />
    <Password v-else-if="component === 'Password'" :id="name" v-bind="$attrs" :class="$page.props.errors[name] ? 'p-invalid' : ''" >
        <template #header>
            <h3>Pick a password</h3>
        </template>
        <template #footer>
            <Divider />
            <p class="mt-2">Suggestions</p>
            <ul class="pl-2 ml-2 mt-0" style="line-height: 1.5">
                <li>At least one lowercase</li>
                <li>At least one uppercase</li>
                <li>At least one numeric</li>
                <li>Minimum 8 characters</li>
            </ul>
        </template>
    </Password>
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
