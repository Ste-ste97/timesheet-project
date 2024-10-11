<template>
    <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

    <div class="card">
        <ReusableDataTable
            :dataObject="clients"
            resourceName="clients"
            primaryKey="id"
            :showPageTitle="true"
            :pageTitle="__('Manage Clients')"
            :emptyMessage="__('No clients found.')"
            :columns="dataColumns"
            key="clients"
            :showCustomButtons="true"
            @createNewResource="createNewResource"
            @editResource="editResource">
            <template #customColumns="{slotProps}">
                <Column field="email" header="Email">
                    <template #body="slotProps">
                        <a href="#" @click.prevent="createNewEmail(slotProps.data.email)">
                            {{ slotProps.data.email }}
                        </a>
                    </template>
                </Column>
            </template>
        </ReusableDataTable>

        <!--        <ReusableForm v-model:visible="formVisible" :action="action" :item="item" :fields="dataColumns['items']" dialogHeader="Client Details"-->
        <!--                      resourceName="clients" primaryKey="id"/>-->

        <ClientForm v-model:visible="formVisible" :action="action" :client="item" :fields="dataColumns['items']" :users="users"/>

    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import ReusableDataTable from '@/Components/Primitives/ReusableDataTable.vue';
import ReusableForm from '@/Components/Primitives/ReusableForm.vue';
import ClientForm from "./Partials/ClientForm.vue"

export default {
    layout     : AuthenticatedLayout,
    components : {ReusableForm, ReusableDataTable, ClientForm},
    props      : {
        clients     : Object,
        dataColumns : Object,
        users       : Object,
    },
    data() {
        return {
            item        : null,
            formVisible : false,
            action      : "",
            home        : {
                icon : 'pi pi-home',
            },
        }
    },
    computed : {
        items() {
            return [
                {label : this.__('Clients')},
            ]
        }
    },
    methods  : {
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
        createNewEmail(email) {
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${email}`;
            window.open(gmailUrl, '_blank');
        }
    },
}
</script>

<style lang="scss" scoped>
.table-header {
    display         : flex;
    align-items     : center;
    justify-content : space-between;
}
</style>
