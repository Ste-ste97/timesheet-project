<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <h2 class="mb-4">Manage Total Timesheet Cost of {{ currentYear }}</h2>
        <DataTable :value="tableData" :expandedRows="expandedCompanies" v-model:expandedRows="expandedCompanies" removableSort showGridlines  :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]">
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
                    <Column  field="total_cost_for_user_in_company" header="Personal Cost" sortable>
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

export default {
    layout     : AuthenticatedLayout,
    props      : {
        timesheetsCompanies : Object,
    },
    mixins     : [DataTableMixins],
    components : {
        TimesheetForm
    },
    data() {
        return {
            tableData                : this.timesheetsCompanies,
            expandedUsers            : [],
            expandedCompanies        : [],
            item                     : null,
            formVisible              : false,
            action                   : "",
            home                     : {
                icon : 'pi pi-home',
            },
            items                    : [
                {label : "Total TimeSheets Cost"},
            ],
        };
    },
    computed : {
        currentYear() {
            return new Date().getFullYear();
        }
    },
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
