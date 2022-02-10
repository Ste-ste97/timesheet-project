<template>
    <h3>
        Users
    </h3>
        <div class="surface-section px-4 py-4">
            <ConfirmDialog></ConfirmDialog>

            <Toolbar class="mb-4">
                <template #start>
                    <Button label="New" icon="pi pi-plus" class="p-button-success mr-2 mb-2" @click="createNewUser()" />
                    <Button label="Delete" icon="pi pi-trash" class="p-button-danger mb-2" @click="massDeleteUsers()" :disabled="!selectedUsers || !selectedUsers.length" />
                </template>

                <template #end>
                    <Button label="Export" icon="pi pi-upload" class="p-button-help mb-2" @click="exportCSV($event)"  />
                </template>
            </Toolbar>
            <div class="card">
            <DataTable ref="dt" :value="users" v-model:selection="selectedUsers"
                      :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]"
                       responsiveLayout="scroll" >
                <template #empty>
                    No users found.
                </template>
                <Column selectionMode="multiple" style="width: 3rem" :exportable="false"></Column>
                <Column field="id" header="Id" :sortable="true"></Column>
                <Column field="name" header="Name" :sortable="true"></Column>
                <Column field="email" header="Email" :sortable="true"></Column>
                <Column header="Actions" :exportable="false">
                    <template #body="slotProps">
                        <Button icon="pi pi-pencil"  class="p-button-rounded mr-2" @click="editUser(slotProps.data)" />
                        <Button icon="pi pi-trash" iconPos="left" @click="deleteUser(slotProps.data.id)"  class="p-button-rounded p-button-danger" />
                    </template>
                </Column>
            </DataTable>
            </div>

            <UserForm v-model:visible="userDialog" :user="user" :action="action"/>
        </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import UserForm from "./Partials/UserForm.vue"
import { Inertia } from '@inertiajs/inertia'

export default {
    layout: AuthenticatedLayout,
    components:{
        UserForm
    },
    props:{
        users: Object,
    },
    data(){
        return{
            selectedUsers: null,
            user: null,
            userDialog: false,
            action: ""
        }
    },
    methods:{
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        deleteUser(id){
            this.$confirm.require({
                message: 'Are you sure you want to delete this user?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    Inertia.delete(route('users.destroy', id))
                },
                reject: () => {
                }
            });
        },
        createNewUser(){
            this.user = null
            this.action="Create"
            this.userDialog=true;
        },
        editUser(user){
            this.user = user;
            this.action="Edit"
            this.userDialog=true;
        },
        massDeleteUsers() {
            console.log(this.selectedUsers)
            this.$confirm.require({
                message: 'Are you sure you want to delete all this users?',
                header: 'Confirmation',
                icon: 'pi pi-exclamation-triangle',
                accept: () => {
                    Inertia.post(route('users.massDestroy'), {
                        users: this.selectedUsers,
                    },
                    {
                        onSuccess: () =>  this.selectedUsers = [],
                    })
                },
                reject: () => {
                }
            });
        }
    }
};
</script>

