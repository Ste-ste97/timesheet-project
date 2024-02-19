<template>
    <h1 v-if="showPageTitle" class="mb-4 p-as-md-center">{{ pageTitle }}</h1>

    <DataTable ref="dt" v-model:selection="selected" :filters="filters" :first="from"
               :lazy="true" :loading="loading"
               :paginator="true" :reorderableColumns="true" :resizableColumns="true"
               :rows="perPage" :rowsPerPageOptions="rowsPerPageOptions" :sortField="sortField" :sortOrder="sortOrderInt"
               :totalRecords="total"
               :value="data" columnResizeMode="expand" removableSort responsiveLayout="scroll"
               showGridlines @page="onPage($event)" @sort="onSort" @update:rows="perPage = $event">

        <template #header>
            <div class="flex flex-column md:justiify-content-between">
                <Toolbar>
                    <template #start>
                        <Button v-if="showCreateButton"
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
                                <InputText v-model="searchData" class="p-inputtext-sm" placeholder="Search..."
                                           @keydown.enter="searchTerm"/>
                            </div>
                        </div>
                    </template>
                </Toolbar>
            </div>

            <div style="text-align:left">
                <MultiSelect v-show="showSelectColumns" :modelValue="selectedColumns" :options="columns"
                             class="w-full" display="chip"
                             filter optionGroupChildren="items" optionGroupLabel="label"
                             optionLabel="header" placeholder="Select Columns" @update:modelValue="onToggle"/>
            </div>
        </template>

        <template #empty>
            {{ emptyMessage }}
        </template>
        <Column v-if="showMassDeleteButton" :exportable="false" selectionMode="multiple" style="width: 3rem"></Column>
        <Column v-for="(col, index) in selectedColumns" :key="col.field + '_' + index" :field="col.field"
                :header="col.header" :sortable="true">
        </Column>

        <slot name="customColumns"></slot>

        <Column :exportable="false" :field="primaryKey">
            <template #body="slotProps">
                <slot :slotProps="slotProps" name="customButtons"></slot>
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
        <InputNumber v-model="page" :max="lastPage" :min="1" mode="decimal" @keydown.enter="onPageButton(page)"/>
        <Button label="Go" @click="onPageButton(page)"/>
    </div>

</template>

<script>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTableMixins from "@/Components/Mixins/DataTableMixins.vue";

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
        items                : {
            type    : Array,
            default : () => [],
        },
        createNewResource    : {
            type : Function,
            default() {
                return () => {
                };
            },
        },
        editResource         : {
            type : Function,
            default() {
                return () => {
                };
            },
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
            routeOriginal   : null,
            from            : null,
            data            : null,
            page            : null,
            perPage         : null,
            total           : null,
            lastPage        : null,
            selectedColumns : [],
        };
    },
    mounted() {
        this.init();
    },
    methods : {
        init() {
            this.routeOriginal = this.dataObject.path
            this.from          = this.dataObject.from
            this.data          = this.dataObject.data
            this.page          = this.dataObject.current_page
            this.perPage       = this.dataObject.per_page
            this.total         = this.dataObject.total
            this.lastPage      = this.dataObject.last_page
        },
        async deleteResource(id) {
            this.$confirm.require({
                message : 'Are you sure you want to delete this item?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.$inertia.delete(route(this.routeDestroy, id));
                }
            });
        },
        async massDeleteResource() {
            this.$confirm.require({
                message : 'Are you sure you want to delete all these items?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.$inertia.post(route(this.routeMassDestroy), {
                        selected  : this.selected,
                    });
                },
            });
        },
        onToggle(value) {
            this.selectedColumns = this.columns.flatMap(group => group.items).filter(col => value.includes(col));
        },
    },
    created() {
        if (this.defaultColumns.length === 0) {
            this.selectedColumns = this.columns.flatMap(group => group.items);
        } else {
            this.defaultColumns.forEach((field) => {
                const column = this.columns.flatMap(group => group.items).find(item => item.field === field);

                if (column) {
                    this.selectedColumns.push(column);
                }
            });
        }
    },
    watch : {
        'dataObject' : function () {
            this.init();
        }
    }
};
</script>
