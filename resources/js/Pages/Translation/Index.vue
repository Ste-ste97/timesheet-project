<template>
    <div class="card">

        <Toolbar class="mb-4">
            <template #start>
                <Button v-has-permission="{props: $page.props, permissions: ['translations.create']}" class="p-button-success mr-2 mb-2" icon="pi pi-plus" label="New" @click="createNewResource()"/>
                <Button v-has-permission="{props: $page.props, permissions: ['translations.delete']}" :disabled="!selected || !selected.length" class="p-button-danger mb-2" icon="pi pi-trash"
                        label="Delete"
                        @click="massDeleteResource()"/>
                <Dropdown class="ml-2 mb-2" :options="languages" v-model="language"/>
            </template>

            <template #end>
                <Button class="p-button-help mb-2" icon="pi pi-upload" label="Export" @click="exportCSV($event)"/>
            </template>
        </Toolbar>
        <div class="card">
            <DataTable ref="dt" v-model:selection="selected" :filters="filters"
                       :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]"
                       :value="translations" responsiveLayout="scroll">
                <template #header>
                    <div class="table-header flex flex-column md:flex-row md:justiify-content-between">
                        <h5 class="mb-2 md:m-0 p-as-md-center">Manage Translations</h5>
                        <InputText v-model="filters['global'].value" class="p-inputtext-sm" placeholder="Search..."/>
                    </div>
                </template>
                <template #empty>
                    No translations found.
                </template>
                <Column :exportable="false" selectionMode="multiple" style="width: 3rem"></Column>
                <Column :sortable="true" field="key" header="Key"></Column>
                <Column :sortable="true" field="value" header="Value"></Column>
                <Column :sortable="true" field="language" header="Language"></Column>
                <Column :exportable="false">
                    <template #body="slotProps">
                        <Button v-has-permission="{props: $page.props, permissions: ['translations.edit']}" class="p-button-rounded mr-2" icon="pi pi-pencil" @click="editResource(slotProps.data)"/>
                        <Button v-has-permission="{props: $page.props, permissions: ['translations.delete']}" class="p-button-rounded p-button-danger" icon="pi pi-trash" iconPos="left"
                                @click="deleteResource(slotProps.data.id)"/>
                    </template>
                </Column>
            </DataTable>
        </div>

        <TranslationForm v-model:visible="formVisible" :action="action" :translation="translation"/>
    </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import TranslationForm from "./Partials/TranslationForm.vue"
import {FilterMatchMode} from 'primevue/api';

export default {
    layout     : AuthenticatedLayout,
    components : {
        TranslationForm
    },
    props      : {
        translations : Object,
    },
    data() {
        return {
            selected    : null,
            translation : null,
            formVisible : false,
            action      : "",
            filters     : {},
            language    : this.$page.props.language ?? 'en',
            languages   : ['en', 'gr']
        }
    },
    created() {
        this.initFilters();
    },

    methods : {
        exportCSV() {
            this.$refs.dt.exportCSV();
        },
        deleteResource(id) {
            this.$confirm.require({
                message : 'Are you sure you want to delete this translation?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.$inertia.delete(route('translations.destroy', id))
                },
                reject  : () => {
                }
            });
        },
        createNewResource() {
            this.translation = null
            this.action      = "Create"
            this.formVisible = true;
        },
        editResource(translation) {
            this.translation = translation;
            this.action      = "Edit"
            this.formVisible = true;
        },
        massDeleteResource() {
            this.$confirm.require({
                message : 'Are you sure you want to delete all this translations?',
                header  : 'Confirmation',
                icon    : 'pi pi-exclamation-triangle',
                accept  : () => {
                    this.$inertia.post(route('translations.massDestroy'), {
                            translations : this.selected,
                        },
                        {
                            onSuccess : () => this.selected = [],
                        })
                },
                reject  : () => {
                }
            });
        },
        initFilters() {
            this.filters = {
                'global' : {value : null, matchMode : FilterMatchMode.CONTAINS},
            }
        }
    },
    watch   : {
        language(value) {
            this.$inertia.visit(route('translations.index'), {
                data : {language : value}
            })
        }
    }
};
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
