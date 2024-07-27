<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <ReusableDataTable
            :dataObject="services"
            resourceName="services"
            primaryKey="id"
            :showPageTitle="true"
            pageTitle="Manage Services"
            emptyMessage="No services found."
            :showSelectColumns="true"
            :columns="dataColumns"
            @createNewResource="createNewResource"
            @editResource="editResource"
            key="services">
        </ReusableDataTable>

        <ReusableForm v-model:visible="formVisible" :action="action" :item="item" :fields="dataColumns['items']" dialogHeader="Service Details"
                      resourceName="services" primaryKey="id"/>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import DataTableMixins from "@/Components/Mixins/DataTableMixins.vue";
import ReusableDataTable from '@/Components/Primitives/ReusableDataTable.vue';
import ReusableForm from '@/Components/Primitives/ReusableForm.vue';

export default {
    layout     : AuthenticatedLayout,
    components : {ReusableForm, ReusableDataTable},
    props      : {
        services   : Object,
        dataColumns : Object,
    },
    mixins     : [DataTableMixins],
    data() {
        return {
            item        : null,
            formVisible : false,
            action      : "",
            home        : {
                icon : 'pi pi-home',
            },
            items       : [
                {label : "Services"},
            ],
            columns     : [this.dataColumns],
        }
    },
    methods : {
        createNewResource() {
            this.item        = null;
            this.action      = "Create";
            this.formVisible = true;
        },
        editResource(item) {
            this.item        = item;
            this.action      = "Edit";
            this.formVisible = true;
        },
        showResource(item) {
            this.item        = item;
            this.action      = "Show";
            this.formVisible = true;
        },
    },
}
</script>

<style lang="scss" scoped>
.table-header {
    display         : flex;
    align-items     : center;
    justify-content : space-between;

    @media screen and (max-width : 960px) {
        align-items : start;
    }
}
</style>
