<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <h2 class="mb-4">Manage Timesheet of {{ currentYear }}</h2>

        <DataTable ref='userDt' :value="tableData" :expandedRows="expandedUsers" v-model:expandedRows="expandedUsers" @row-expand="onUserToggle"
                   v-model:selection="selected" :filters="filters"
                   :paginator="true" :rows="10" :rowsPerPageOptions="[10,25,50]" showGridlines>
            <Toolbar>
                <template #start>
                    <Button v-has-permission=" {props: $page.props, permissions: ['timesheets.create']}"
                            :label="__('New')" class="p-button-success mr-2" icon="pi pi-plus"
                            @click="createNewResource()"/>
                    <Button v-has-permission="{props: $page.props, permissions: ['timesheets.delete']}"
                            :disabled="!selected || !selected.length" :label="__('Delete')"
                            class="p-button-danger mr-2"
                            icon="pi pi-trash"
                            @click="massDeleteResource()"/>
                    <Button icon="pi pi-minus" label="Collapse All" @click="collapseAll"/>
                </template>
            </Toolbar>

            <template #header>
                <h4 class="mb-4">Manage Users</h4>
            </template>

            <template #empty>
                No Users found
            </template>

            <Column :expander="true" headerStyle="width: 3rem"/>
            <Column field="name" header="User"></Column>

            <template #expansion="slotProps">
                <div v-if="loading" class="custom-spinner">
                    <i class="pi pi-spin pi-spinner"></i>
                </div>
                <div v-else>
                    <DataTable :value="slotProps.data.companies" :expandedRows="expandedCompanies" v-model:expandedRows="expandedCompanies" @row-expand="onCompanyToggle" removableSort>
                        <template #header>
                            <h4 class="mb-4">Manage Companies</h4>
                        </template>

                        <template #empty>
                            No Companies found
                        </template>
                        <Column :expander="true" headerStyle="width: 3rem"/>
                        <Column field="name" header="Company"></Column>
                        <Column field="total_hours_for_user_in_company" header="Total Hours" sortable></Column>
                        <Column field="cost" header="Total Cost" sortable>
                            <template #body="slotProps">
                                {{ formatCurrency(slotProps.data.cost) }}
                            </template>
                        </Column>
                        <template #expansion="slotProps2">
                            <DataTable :value="slotProps2.data.months" :expandedRows="expandedMonths" v-model:expandedRows="expandedMonths" @row-expand="onMonthToggle">
                                <template #header>
                                    <h4 class="mb-4">Manage Monthly TimeSheets </h4>
                                </template>

                                <template #empty>
                                    No Monthly TimeSheets found
                                </template>

                                <Column :expander="true" headerStyle="width: 3rem"/>
                                <Column field="month" header="Month"></Column>
                                <template #expansion="slotProps3">
                                    <DataTable :value="slotProps3.data.services" ref="dt" v-model:selection="selected" :filters="filters"
                                               responsiveLayout="scroll" removableSort>

                                        <template #header>
                                            <h4 class="mb-4">Manage Services</h4>
                                        </template>

                                        <template #empty>
                                            No services found
                                        </template>

                                        <Column :exportable="false" selectionMode="multiple" style="width: 3rem"></Column>
                                        <Column field="service.name" header="Service" sortable></Column>
                                        <Column field="date" header="Date" sortable>
                                            <template #body="slotProps4">
                                                {{ formatDate(slotProps4.data.date) }}
                                            </template>
                                        </Column>
                                        <Column field="hours" header="Hours" sortable></Column>
                                        <Column :exportable="false">
                                            <template #body="slotProps">
                                                <Button v-has-permission="{props: $page.props, permissions: ['timesheets.edit']}"
                                                        class="p-button-rounded mr-2" icon="pi pi-pencil" @click="editResource(slotProps.data)"/>
                                                <Button v-has-permission="{props: $page.props, permissions: ['timesheets.delete']}"
                                                        class="p-button-rounded p-button-danger" icon="pi pi-trash"
                                                        @click="deleteResource(slotProps.data.id)"/>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </template>
                            </DataTable>
                        </template>
                    </DataTable>
                </div>
            </template>

        </DataTable>

        <TimesheetForm v-model:visible="formVisible" :action="action" :timesheet="item"/>
    </div>

</template>

<script>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTableMixins from '@/Components/Mixins/DataTableMixins.vue';
import TimesheetMixins from '@/Components/Mixins/TimesheetMixins.vue';
import TimesheetForm from '@/Pages/TimeSheet/Partials/TimesheetForm.vue';

export default {
    layout     : AuthenticatedLayout,
    props      : {
        timesheetsUsers : Object,
    },
    mixins     : [DataTableMixins, TimesheetMixins],
    components : {
        TimesheetForm
    },
    data() {
        return {
            tableData         : this.timesheetsUsers,
            expandedUsers     : [],
            expandedCompanies : [],
            expandedMonths    : [],
            item              : null,
            formVisible       : false,
            action            : "",
            home              : {
                icon : 'pi pi-home',
            },
            items             : [
                {label : "TimeSheets"},
            ],
            selected          : null,
            filters           : {},
        };
    },
    methods : {
        collapseAll() {
            this.expandedUsers     = [];
            this.expandedCompanies = [];
            this.expandedMonths    = [];
        },
        async onUserToggle(event) {
            const userId = event.data.id;
            this.loading = true;
            try {
                const response                = await axios.get(route('timesheets.getCompanies', {userId}));
                const row                     = this.tableData.findIndex(item => item.id === userId);
                this.tableData[row].companies = response.data;
            } catch (error) {
                console.error("Error fetching data: ", error);
            }
            this.loading = false;
        },
        async onCompanyToggle(event) {
            const userId    = event.data.pivot.user_id;
            const companyId = event.data.pivot.company_id;
            console.log(userId, companyId);
            console.log(this.tableData);

            try {
                const response = await axios.get(route('timesheets.getMonthlyTimeSheets', {userId, companyId}));
                const row1     = this.tableData.findIndex(item => item.id === userId);
                const row2     = this.tableData[row1].companies.findIndex(item => item.id === companyId);

                const months = Object.keys(response.data).map(monthName => {
                    return {
                        month        : monthName,
                        month_number : response.data[monthName][0].month_number,
                        user_id      : userId,
                        company_id   : companyId
                    };
                });

                this.tableData[row1].companies[row2].months = months;
            } catch (error) {
                console.error("Error fetching data: ", error);
            } finally {
                this.$forceUpdate();
            }
        },
        async onMonthToggle(event) {
            const userId      = event.data.user_id;
            const companyId   = event.data.company_id;
            const monthNumber = event.data.month_number;

            try {
                const response                                             = await axios.get(route('timesheets.getServices', {userId, companyId, monthNumber}));
                const row1                                                 = this.tableData.findIndex(item => item.id === userId);
                const row2                                                 = this.tableData[row1].companies.findIndex(item => item.id === companyId);
                const row3                                                 = this.tableData[row1].companies[row2].months.findIndex(item => item.month_number === monthNumber);
                this.tableData[row1].companies[row2].months[row3].services = response.data;
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
