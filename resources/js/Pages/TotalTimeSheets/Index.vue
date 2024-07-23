<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <h2 class="mb-4">Manage Total Timesheet Cost of {{ currentYear }}</h2>
        <DataTable :value="tableData" :expandedRows="expandedCompanies" v-model:expandedRows="expandedCompanies" @row-expand="onCompanyToggle">
            <template #header>
                <h4 class="mb-4">Manage Companies Total Cost </h4>
            </template>

            <Column :expander="true" headerStyle="width: 3rem"/>
            <Column field="company.name" header="Company"></Column>
            <Column field="cost" header="Cost">
                <template #body="slotProps">
                    {{ formatCurrency(slotProps.data.cost) }}
                </template>
            </Column>
            <template #expansion="slotProps">
                <DataTable :value="slotProps.data.usersTotalCost">
                    <template #header>
                        <h4 class="mb-4">Manage User Total Cost</h4>
                    </template>

                    <Column field="name" header="Users"></Column>
                    <Column field="cost" header="Total Cost">
                        <template #body="slotProps">
                            {{ formatCurrency(slotProps.data.cost) }}
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
            tableData                : this.timesheetsCompanies?.data,
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
            loadingCompanyTimesheets : {},
        };
    },
    computed : {
        currentYear() {
            return new Date().getFullYear();
        }
    },
    methods  : {
        async onCompanyToggle(event) {
            console.log(event);
            const companyId = event.data.company_id;

            try {
                const response                     = await axios.get(route('totalTimesheetsCost.getUserTotalCostByCompanyId', {companyId}));
                const row                          = this.tableData.findIndex(item => item.company_id === companyId);
                this.tableData[row].usersTotalCost = response.data;
            } catch (error) {
                console.error("Error fetching data: ", error);
            } finally {
                this.$forceUpdate();
            }
        },
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
