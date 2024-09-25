<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <ReusableDataTable
            :dataObject="contacts"
            resourceName="contacts"
            primaryKey="id"
            :showPageTitle="true"
            pageTitle="Manage Contacts"
            emptyMessage="No contacts found."
            :showSelectColumns="true"
            :columns="dataColumns"
            @createNewResource="createNewResource"
            @editResource="editResource"
            key="contacts">
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

        <ReusableForm v-model:visible="formVisible" :action="action" :item="item" :fields="dataColumns['items']" dialogHeader="Contact Details"
                      resourceName="contacts" primaryKey="id"/>
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
        contacts    : Object,
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
                {label : "Contacts"},
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

    @media screen and (max-width : 960px) {
        align-items : start;
    }
}
</style>
