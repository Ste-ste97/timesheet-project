<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <div class="mb-4">
            <h2>Manage Total Timesheet Cost</h2>
            <FormField v-model="selectedYear" name="selectedYear" :options="years" component="Dropdown" @change="onYearChange"/>
        </div>

        <DataTable :value="tableData" :expandedRows="expandedCompanies" v-model:expandedRows="expandedCompanies" removableSort showGridlines :paginator="true" :rows="10"
                   :rowsPerPageOptions="[10,25,50]">
            <Toolbar>
                <template #start>
                    <Button icon="pi pi-minus" label="Collapse All" @click="collapseAll"/>
                </template>
            </Toolbar>
            <template #header>
                <h4 class="mb-4">Manage Companies Total Cost </h4>
            </template>

            <Column :expander="true" headerStyle="width: 3rem"/>
            <Column field="name" header="Company" sortable></Column>
            <Column field="total_cost" header="Total Company Cost" sortable>
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.total_cost) }}
                </template>
            </Column>
            <template #expansion="slotProps">
                <DataTable :value="slotProps.data.users">
                    <template #header>
                        <h4 class="mb-4">Manage User Total Cost</h4>
                    </template>

                    <Column field="name" header="Users"></Column>
                    <Column field="total_cost_for_user_in_company" header="Personal Cost" sortable>
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.total_cost_for_user_in_company) }}
                        </template>
                    </Column>
                </DataTable>
            </template>
        </DataTable>

        <TimesheetForm v-model:visible="formVisible" :action="action" :timesheet="item"/>
    </div>

</template>

<script>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTableMixins from '@/Components/Mixins/DataTableMixins.vue';
import TimesheetForm from '@/Pages/TimeSheet/Partials/TimesheetForm.vue';
import FormField from '@/Components/Primitives/FormField.vue';
import TimesheetMixins from '@/Components/Mixins/TimesheetMixins.vue';

export default {
    layout     : AuthenticatedLayout,
    props      : {
        timesheetsCompanies : Object,
    },
    mixins     : [DataTableMixins, TimesheetMixins],
    components : {
        FormField,
        TimesheetForm
    },
    data() {
        return {
            tableData         : this.timesheetsCompanies,
            expandedUsers     : [],
            expandedCompanies : [],
            item              : null,
            formVisible       : false,
            action            : "",
            home              : {
                icon : 'pi pi-home',
            },
            items             : [
                {label : "Total TimeSheets Cost"},
            ],
        };
    },
    methods : {
        async onYearChange() {
            await axios.get(route('totalTimesheetsCost.changeYear'), {
                params : {
                    year : this.selectedYear,
                },
            }).then(response => {
                this.tableData = response.data.timesheetsCompanies;
            });
        },
        collapseAll() {
            this.expandedCompanies = [];
        },
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
