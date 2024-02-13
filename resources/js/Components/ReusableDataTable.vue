<template>
    <h1 v-if="showPageTitle" class="mb-4 p-as-md-center">{{ pageTitle }}</h1>

    <DataTable ref="dt" :first="from" :value="data" v-model:selection="selected"
               :totalRecords="total" @page="onPage($event)"
               :paginator="true" :rows="perPage" :rowsPerPageOptions="rowsPerPageOptions"
               @update:rows="perPage = $event" :resizableColumns="true" columnResizeMode="expand" showGridlines
               :filters="filters"
               :lazy="true" responsiveLayout="scroll" :reorderableColumns="true" removableSort
               @sort="onSort" :sortField="sortField" :sortOrder="sortOrderInt" :loading="loading">

        <template #header>
            <div class="flex flex-column md:justiify-content-between">
                <Toolbar>
                    <template #start>
                        <Button v-if=" showCreateButton"
                                v-has-permission="{props: $page.props, permissions: [permissionCreate]}"
                                class="p-button-success mr-2" icon="pi pi-plus" label="New"
                                @click="createNewResource()"/>
                        <Button v-if="showMassDeleteButton"
                                v-has-permission="{props: $page.props, permissions: [permissionMassDelete]}"
                                :disabled="!selected || !selected.length" class="p-button-danger"
                                icon="pi pi-trash"
                                label="Delete"
                                @click="massDeleteResource()"/>
                    </template>

                    <template #end>
                        <div class="grid formgrid p-fluid">
                            <div class="m-2">
                                <Button class="p-button-help mr-2" icon="pi pi-upload" label="Export"
                                        @click="exportCSV($event)"/>
                            </div>
                            <div class="m-2">
                                <InputText v-model="searchData" @keydown.enter="searchTerm" class="p-inputtext-sm"
                                           placeholder="Search..."/>
                            </div>
                        </div>
                    </template>
                </Toolbar>
            </div>

            <div style="text-align:left">
                <MultiSelect v-show="showSelectColumns" :modelValue="selectedColumns" :options="columns"
                             optionLabel="header" filter
                             optionGroupLabel="label" optionGroupChildren="items" class="w-full"
                             display="chip" placeholder="Select Columns" @update:modelValue="onToggle"/>
            </div>
        </template>

        <template #empty>
            {{ emptyMessage }}
        </template>
        <Column v-if="showMassDeleteButton" :exportable="false" selectionMode="multiple" style="width: 3rem"></Column>
        <Column v-for="(col, index) in selectedColumns" :field="col.field" :header="col.header"
                :key="col.field + '_' + index" :sortable="true">
        </Column>

        <slot name="customColumns"></slot>

        <Column v-if="hasPermission" :exportable="false">
            <template #body="slotProps">
                <slot name="customButtons" :slotProps="slotProps"></slot>
                <Button v-has-permission="{props: $page.props, permissions: [permissionEdit]}"
                        class="p-button-rounded mr-2" icon="pi pi-pencil" @click="editResource(slotProps.data)"/>
                <Button v-has-permission="{props: $page.props, permissions: [permissionDelete]}"
                        class="p-button-rounded p-button-danger" icon="pi pi-trash"
                        @click="deleteResource(slotProps.data[primaryKey])"/>
            </template>
        </Column>

    </DataTable>

    <div>
        Jump to page
        <InputNumber v-model="page" mode="decimal" :min="1" :max="lastPage" @keydown.enter="onPageButton(page)"/>
        <Button label="Go" @click="onPageButton(page)"/>
    </div>

</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTableMixins from "@/Components/Mixins/DataTableMixins.vue";
import axios from 'axios';

export default {
    layout : AuthenticatedLayout,

    props  : {
        dataObject           : Object,
        routeDestroy         : String,
        routeMassDestroy     : String,
        routeIndex           : String,
        primaryKey           : String,
        showCreateButton     : {
            type    : Boolean,
            default : true,
        },
        showEditButton       : {
            type    : Boolean,
            default : true,
        },
        showDeleteButton     : {
            type    : Boolean,
            default : true,
        },
        showMassDeleteButton : {
            type    : Boolean,
            default : true,
        },
        showPageTitle        : {
            type    : Boolean,
            default : false,
        },
        pageTitle            : {
            type    : String,
            default : "Manage Interested Stakeholders",
        },
        permissionCreate     : {
            type : String,
        },
        permissionMassDelete : {
            type : String,
        },
        permissionEdit       : {
            type : String,
        },
        permissionDelete     : {
            type : String,
        },
        emptyMessage         : {
            type    : String,
            default : "No records found.",
        },
        showSelectColumns    : {
            type    : Boolean,
            default : true,
        },
        columns              : {
            type    : Array,
            default : () => [],
        },
        defaultColumns       : {
            type    : Array,
            default : () => [],
        },
    },
    mixins : [DataTableMixins],
    data() {
        return {
            routeOriginal : this.dataObject.path,
            from          : this.dataObject.from,
            data          : this.dataObject.data,
            page          : this.dataObject.current_page,
            perPage       : this.dataObject.per_page,
            total         : this.dataObject.total,
            lastPage      : this.dataObject.last_page,

            selectedColumns : [],
        };
    },
    computed : {
        hasPermission() {
            return this.userPermissions.some(item => item.name === this.permissionEdit || item.name === this.permissionDelete);
        },
    },
    methods : {
        async deleteResource(id) {
            const that = this;
            this.$confirm.require({
                message : 'Are you sure you want to delete this item?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    axios({
                        method : 'delete',
                        url    : route(this.routeDestroy, id),
                    }).then(function (response) {
                        if (response.status === 200) {
                            that.$inertia.get(route(that.routeIndex));
                        }
                    }).catch(error => console.log(error));
                },
                reject  : () => {
                },
            });
        },
        createNewResource() {
            this.$emit("createNewResource");
        },
        editResource(item) {
            this.$emit("editResource", item);
        },
        async massDeleteResource() {
            const that = this;
            this.$confirm.require({
                message : 'Are you sure you want to delete all these items?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    axios({
                        method : 'post',
                        url    : route(this.routeMassDestroy),
                        data   : {
                            selected : this.selected,
                        },
                    }).then(function (response) {
                        if (response.status === 200) {
                            that.$inertia.get(route(that.routeIndex));
                        }
                    }).catch(error => console.log(error));
                },
                reject  : () => {
                }
            });
        },
        onToggle(value) {
            // Flatten the array of groups to get all individual items
            const allColumns = this.columns.flatMap(group => group.items);
            // Filter the flattened array based on the selected values

            this.selectedColumns = allColumns.filter(col => value.includes(col));

        },
    },
    created() {
        if (this.defaultColumns.length === 0) {
            this.selectedColumns = this.columns.flatMap(group => group.items);
        } else {
            this.defaultColumns.forEach((field) => {
                // Find the corresponding column based on the field name
                const column = this.columns.flatMap(group => group.items).find(item => item.field === field);

                // Add the column to the selectedColumns array
                if (column) {
                    this.selectedColumns.push(column);
                }
            });
        }
    },
};
</script>

<style scoped>
.table-header {
    display: flex;
    align-items: center;
    justify-content: space-between;

    @media screen and (max-width: 960px) {
        align-items: start;
    }
}

.top-margin {
    margin-top: 20px;
}

.p-paginator {
    align-items: start;
    justify-content: left;
}

.date-fields-container {
    display: flex;
    align-items: center; /*center align */
    justify-content: flex-start;
    gap: 1rem;
}

.field {
    flex: 1; /* Every  field has same distance */
    min-height: 50px;
    margin-bottom: 0;
}
</style>
