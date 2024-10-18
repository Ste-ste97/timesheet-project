<template>
    <div class="card">
        <Breadcrumb class="mb-4" :home="home" :model="items" style="pointer-events : none;"/>
        <div class="flex justify-content-center">
            <Card class="m-2 search-card">

                <template #content>
                    <div class="grid">
                        <h2>{{ __('Advanced Timesheet') }}</h2>
                    </div>

                    <form class="grid formgrid p-fluid">
                        <div class="field mb-4 col-6">
                            <FormField v-model="filters.user_ids"
                                       :label="__('Users')"
                                       :placeholder="__('Select Users')"
                                       name="user_id"
                                       component="MultiSelect"
                                       :options="users"
                                       optionLabel="name"
                                       optionValue="id"/>
                        </div>

                        <div class="field mb-4 col-6">
                            <FormField v-model="filters.frequency"
                                       :label="__('Frequency')"
                                       :options="frequencies"
                                       :placeholder="__('Select frequency')"
                                       component="Dropdown"
                                       name="frequency"
                                       optionLabel="name"
                                       optionValue="value"/>
                        </div>

                        <div v-if="showYear" class="field mb-4 col-6">
                            <FormField v-model="filters.year"
                                       :label="__('Year')"
                                       :placeholder="__('Select Year')"
                                       component="Calendar"
                                       name="year"
                                       view="year"
                                       dateFormat="yy"
                                       optionLabel="name"
                                       optionValue="id"/>
                        </div>

                        <div v-if="showMonth" class="field mb-4 col-6">
                            <FormField v-model="filters.month_year"
                                       :label="__('Month Year')"
                                       :placeholder="__('Select Month and Year')"
                                       component="Calendar"
                                       name="month_year"
                                       view="month"
                                       dateFormat="mm/yy"
                                       optionLabel="name"
                                       optionValue="id"/>
                        </div>

                        <div class="field mb-4 col-6">
                            <FormField v-model="filters.client_ids"
                                       :label="__('Clients')"
                                       :placeholder="__('Select Clients')"
                                       name="client_id"
                                       component="MultiSelect"
                                       :options="clients"
                                       optionLabel="name"
                                       optionValue="id"/>
                        </div>

                        <div class="field mb-4 col-6">
                            <FormField v-model="filters.service_ids"
                                       :label="__('Services')"
                                       :placeholder="__('Select Services')"
                                       name="service_id"
                                       component="MultiSelect"
                                       :options="services"
                                       optionLabel="name"
                                       optionValue="id"/>
                        </div>

                    </form>

                    <div class="grid field">
                        <Button :label="__('Search')" class="p-button-success m-1" icon="pi pi-search" @click="search"/>
                        <Button :label="__('Reset')" class="p-button-danger m-1" icon="pi pi-refresh" @click="clear"/>
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script>

import Card from 'primevue/card';
import {Head, Link} from '@inertiajs/vue3';
import {router} from '@inertiajs/vue3';
import FormField from '@/Components/Primitives/FormField.vue';
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import ReusableDataTable from '@/Components/Primitives/ReusableDataTable.vue';
import TimesheetMixins from '@/Components/Mixins/TimesheetMixins.vue';

export default {
    layout     : AuthenticatedLayout,
    components : {
        ReusableDataTable,
        Head,
        FormField,
        Card,
        Link,
    },
    mixins     : [TimesheetMixins],
    props      : {
        timesheets  : Object,
        dataColumns : Object,
        users       : Object,
        clients     : Object,
        services    : Object,

    },
    data() {
        return {
            home        : {
                icon : 'pi pi-home',
            },
            items       : [
                {label : "Advanced Timesheet"},
            ],
            filters     : {
                user_ids    : [],
                frequency   : '',
                year        : '',
                month_year  : '',
                client_ids  : [],
                service_ids : [],
            },
            frequencies : [
                {name : 'Yearly', value : 'yearly'},
                {name : 'Monthly', value : 'monthly'},
                {name : 'Weekly', value : 'weekly'},
                {name : 'Daily', value : 'daily'},
            ],
            showYear    : true,
            showMonth   : true,
        }
    },
    computed : {
        old() {
            this.initFilters()
            return this.$page.props.old;
        },
    },
    watch    : {
        'filters.frequency' : function (newVal) {
            if (newVal === undefined) {
                this.showYear  = true;
                this.showMonth = true;
            } else
                if (newVal === 'yearly') {
                    this.showYear  = true;
                    this.showMonth = false;
                } else {
                    this.showYear  = false;
                    this.showMonth = true;
                }
        },
    },
    methods  : {
        search() {
            router.visit(route('timesheets.search'), {
                data           : {
                    filters : this.filters,
                },
                method         : 'post',
                preserveScroll : true,
                preserveState  : true,
            })
        },
        clear() {
            this.filters = {}
            this.search()
        },
        initFilters() {
            this.filters = {
                user_ids    : this.$page.props.old.filters?.user_ids?.map(id => parseInt(id)) ?? '',
                frequency   : this.$page.props.old.filters?.frequency ?? '',
                year        : this.$page.props.old.filters?.year ?? this.currentYear.toString(),
                month_year  : this.$page.props.old.filters?.month_year ?? this.currentMonthYear,
                client_ids  : this.$page.props.old.filters?.client_ids?.map(id => parseInt(id)) ?? [],
                service_ids : this.$page.props.old.filters?.service_ids?.map(id => parseInt(id)) ?? [],
            }
        },
    },
    mounted() {
        this.initFilters()
    },
    created() {
        console.log("Current year is:", this.currentYear.toString());
        console.log("Current month and year is:", this.currentMonthYear);
    }
}
</script>

<style scoped>
.search-card {
    width: 1000px;
}

img {
    max-width: 60%;
    height: auto;
}

.image-container {
    text-align: center;
}

.center-image {
    display: inline-block;
    width: 60%;
}
</style>
