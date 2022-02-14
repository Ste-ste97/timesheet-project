<template>
    <div class="card">
        <ConfirmDialog></ConfirmDialog>

        <Toolbar class="mb-4">
            <template #start>
                <Button label="New Group" icon="pi pi-plus" class="p-button-success mr-2 mb-2" @click="createNewGroup()" />
            </template>

            <template #end>
                <Button label="Export" icon="pi pi-upload" class="p-button-help mb-2" @click="exportCSV($event)"  />
            </template>
        </Toolbar>
        <div class="card">
        <DataTable ref="dt" v-model:expandedRows="expandedRows" :value="permissions"
                    :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]"
                    responsiveLayout="scroll" :filters="filters">
            <template #header>
                <Button icon="pi pi-plus" label="Expand All" @click="expandAll" class="mb-2 mr-2" />
                <Button label="Collapse All" icon="pi pi-minus" class="mb-2" @click="collapseAll"  />
                <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                    <h5 class="mb-2 md:m-0 p-as-md-center">Manage Permissions</h5>
                    <InputText v-model="filters['global'].value" class="p-inputtext-sm" placeholder="Search..." />
                </div>
            </template>
            <template #empty>
                No permissions found.
            </template>

            <Column :expander="true" headerStyle="width: 3rem" />

            <Column field="group_name" header="Group Name"></Column>
            <Column field="guard_name" header="Guard Name" sortable></Column>

            <Column :exportable="false">
                <template #body="slotProps">
                    <Button icon="pi pi-pencil"  class="p-button-rounded mr-2" @click="editGroup(slotProps.data)" />
                    <Button icon="pi pi-trash" iconPos="left" @click="deleteResource(slotProps.data.id)"  class="p-button-rounded p-button-danger" />
                </template>
            </Column>

            <template #expansion="slotProps">
                <Button label="New Permission" icon="pi pi-plus" class="p-button-success mr-2 mb-2" @click="createNewPermission(slotProps.data)" />

                <DataTable :value="slotProps.data.children" responsiveLayout="scroll">
                    <Column field="id" header="Id" :sortable="true"></Column>
                    <Column field="type" header="Type" :sortable="true"></Column>
                    <Column field="description" header="Description"></Column>
                    <Column :exportable="false">
                        <template #body="slotProps">
                            <Button icon="pi pi-pencil"  class="p-button-rounded mr-2" @click="editPermission(slotProps.data)" />
                            <Button icon="pi pi-trash" iconPos="left" @click="deleteResource(slotProps.data.id)"  class="p-button-rounded p-button-danger" />
                        </template>
                    </Column>
                </DataTable>
        </template>
        </DataTable>
        </div>

        <GroupForm v-model:visible="formGroupVisible" :group="group" :action="action"/>
        <PermissionForm v-model:visible="formPermissionVisible" :group="group" :permission="permission" :action="action"/>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import GroupForm from "./Partials/GroupForm.vue"
import PermissionForm from "./Partials/PermissionForm.vue"
import { Inertia } from '@inertiajs/inertia'
import { FilterMatchMode } from 'primevue/api';

export default {
    layout: AuthenticatedLayout,
    components:{
        GroupForm,
        PermissionForm
    },
    props:{
        permissions: Object,
    },
    data(){
        return{
            group: null,
            permission: null,
            formGroupVisible: false,
            formPermissionVisible: false,
            action: "",
            filters: {},
            expandedRows: []
        }
    },
    created() {
        this.initFilters();
    },
    methods:{
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        deleteResource(id){
            this.$confirm.require({
                message: 'Are you sure you want to delete this group/permission?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    Inertia.delete(route('permissions.destroy', id))
                },
                reject: () => {
                }
            });
        },
        createNewGroup(){
            this.group = null
            this.action="Create"
            this.formGroupVisible=true;
        },
        editGroup(group){
            this.group = group;
            this.action="Edit"
            this.formGroupVisible=true;
        },
        createNewPermission(group){
            this.permission = null
            this.group = group;
            this.action="Create"
            this.formPermissionVisible=true;
        },
        editPermission(permission){
            this.permission = permission;
            this.action="Edit"
            this.formPermissionVisible=true;
        },
        initFilters() {
            this.filters = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            }
        },
        collapseAll() {
            this.expandedRows = [];
        },
        expandAll() {
            this.expandedRows = this.permissions.filter(p => p.id);
        }
    }
};
</script>

<style lang="scss" scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @media screen and (max-width: 960px) {
        align-items: start;
	}
}
</style>
