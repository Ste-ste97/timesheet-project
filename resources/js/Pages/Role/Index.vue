<template>
    <h3>
        Roles
    </h3>
        <div class="surface-section px-4 py-4">
            <ConfirmDialog></ConfirmDialog>

            <Toolbar class="mb-4">
                <template #start>
                    <Button label="New" icon="pi pi-plus" class="p-button-success mr-2 mb-2" @click="createNewResource()" />
                    <Button label="Delete" icon="pi pi-trash" class="p-button-danger mb-2" @click="massDeleteResource()" :disabled="!selected || !selected.length" />
                </template>

                <template #end>
                    <Button label="Export" icon="pi pi-upload" class="p-button-help mb-2" @click="exportCSV($event)"  />
                </template>
            </Toolbar>
            <div class="card">
            <DataTable ref="dt" :value="roles" v-model:selection="selected"
                      :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]"
                       responsiveLayout="scroll" :filters="filters">
                <template #header>
                    <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
						<h4 class="mb-2 md:m-0 p-as-md-center">Manage Roles</h4>
                        <InputText v-model="filters['global'].value" class="p-inputtext-sm" placeholder="Search..." />
					</div>
                </template>
                <template #empty>
                    No roles found.
                </template>
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="id" header="Id" :sortable="true"></Column>
                <Column field="name" header="Name" :sortable="true"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil"  class="p-button-rounded mr-2" @click="editResource(slotProps.data)" />
                        <Button icon="pi pi-trash" iconPos="left" @click="deleteResource(slotProps.data.id)"  class="p-button-rounded p-button-danger" />
                    </template>
                </Column>
            </DataTable>
            </div>

            <RoleForm v-model:visible="formVisible" :role="role" :action="action"/>
        </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import RoleForm from "./Partials/RoleForm.vue"
import { Inertia } from '@inertiajs/inertia'
import { FilterMatchMode } from 'primevue/api';

export default {
    layout: AuthenticatedLayout,
    components:{
        RoleForm
    },
    props:{
        roles: Object,
    },
    data(){
        return{
            selected: null,
            role: null,
            formVisible: false,
            action: "",
            filters: {}
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
                message: 'Are you sure you want to delete this role?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    Inertia.delete(route('roles.destroy', id))
                },
                reject: () => {
                }
            });
        },
        createNewResource(){
            this.role = null
            this.action="Create"
            this.formVisible=true;
        },
        editResource(role){
            this.role = role;
            this.action="Edit"
            this.formVisible=true;
        },
        massDeleteResource() {
            this.$confirm.require({
                message: 'Are you sure you want to delete all this roles?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    Inertia.post(route('roles.massDestroy'), {
                        roles: this.selected,
                    },
                    {
                        onSuccess: () =>  this.selected = [],
                    })
                },
                reject: () => {
                }
            });
        },
        initFilters() {
            this.filters = {
                'global': {value: null, matchMode: FilterMatchMode.CONTAINS},
            }
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
