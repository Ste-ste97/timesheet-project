<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>

        <DataTable :value="timesheets" :expandedRows="expandedUsers" @row-toggle="onUserToggle" dataKey="user.id">
            <Column field="user.name" header="User" expander></Column>
            <template #expandedRow="{ data: userGroup }">
                <DataTable :value="userGroup.companies" :expandedRows="expandedCompanies" @row-toggle="onCompanyToggle" dataKey="company.id">
                    <Column field="company.name" header="Company" expander></Column>
                    <Column field="totalHours" header="Total Hours"></Column>
                    <template #expandedRow="{ data: companyGroup }">
                        <DataTable :value="companyGroup.timesheets">
                            <Column field="month" header="Month"></Column>
                            <Column field="hours" header="Hours"></Column>
                        </DataTable>
                    </template>
                </DataTable>
            </template>
        </DataTable>
    </div>
</template>

<script>
import axios from 'axios';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import DataTableMixins from '@/Components/Mixins/DataTableMixins.vue';

export default {
    layout     : AuthenticatedLayout,
    props      : {
        timesheets : Object
    },
    mixins     : [DataTableMixins],
    data() {
        return {
            timesheets: [],
            expandedUsers: [],
            expandedCompanies: [],
            item        : null,
            formVisible : false,
            action      : "",
            home        : {
                icon : 'pi pi-home',
            },
            items       : [
                {label : "TimeSheets"},
            ],
        };
    },
    created() {
        axios.get(route('timesheets.index')).then(response => {
            this.timesheets = response.data.map(userGroup => ({
                user: userGroup.user,
                companies: userGroup.companies.map(companyGroup => ({
                    company: companyGroup.company,
                    totalHours: companyGroup.timesheets.reduce((total, times) => total + times.reduce((monthTotal, item) => monthTotal + item.hours, 0), 0),
                    timesheets: companyGroup.timesheets.map((times, month) => ({
                        month: month,
                        hours: times.reduce((total, item) => total + item.hours, 0)
                    }))
                }))
            }));
        });
    },
    methods: {
        onUserToggle(event) {
            this.expandedUsers = event.data;
        },
        onCompanyToggle(event) {
            this.expandedCompanies = event.data;
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
