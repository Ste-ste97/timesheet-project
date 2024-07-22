<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <h2 class="mb-4">Manage Timesheet of {{ currentYear }}</h2>
        <DataTable :value="tableData" :expandedRows="expandedCompanies" v-model:expandedRows="expandedCompanies" @row-expand="onCompanyToggleUser">
            <template #header>
                <h4 class="mb-4">Manage Companies</h4>
            </template>

            <Column :expander="true" headerStyle="width: 3rem"/>
            <Column field="company.name" header="Company"></Column>
            <Column field="total_hours_for_user_in_company" header="Total Hours"></Column>
            <Column field="cost" header="Total Cost"></Column>
            <template #expansion="slotProps2">
                <DataTable :value="slotProps2.data.timesheets">
                    <template #header>
                        <h4 class="mb-4">Manage Monthly TimeSheets </h4>
                    </template>
                    <Column field="month" header="Month"></Column>
                    <Column field="hours" header="Hours"></Column>
                    <Column :exportable="false">
                        <template #body="slotProps">
                            <Button v-has-permission="{props: $page.props, permissions: ['timesheets.edit']}"
                                    class="p-button-rounded mr-2" icon="pi pi-pencil" @click="editResource(slotProps.data)"/>
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
                {label : "TimeSheets"},
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
        async onCompanyToggleUser(event) {
            const userId    = this.$page.props.auth.user.id;
            const companyId = event.data.company_id;
            try {
                const response                 = await axios.get(route('timesheets.getTimeSheetsByUserIdCompanyId', {userId, companyId}));
                const row                      = this.tableData.findIndex(item => item.company_id === companyId);
                this.tableData[row].timesheets = response.data;
            } catch (error) {
                console.error("Error fetching data: ", error);
            } finally {
                this.$forceUpdate();
            }

            this.$forceUpdate();
        },
        editResource(item) {
            this.item        = item;
            this.action      = "Edit";
            this.formVisible = true;
        },
    },
    created() {
        console.log(this.timesheetsCompanies);
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
