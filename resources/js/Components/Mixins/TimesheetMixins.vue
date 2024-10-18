<script>
export default {
    computed : {
        currentYear() {
            return new Date().getFullYear();
        },
        currentMonthYear() {
            return  (new Date().getMonth() + 1) + '/' +  new Date().getFullYear();
        },
        years() {
            return Array.from({length : 6}, (v, k) => this.currentYear - 5 + k);
        },
    },
    data() {
        return {
            selectedYear : new Date().getFullYear(),
        }
    },
    methods : {
        createNewResource() {
            this.item        = null;
            this.action      = "Create";
            this.formVisible = true;
        },
        editResource(item) {
            this.item        = item;
            this.action      = "Edit";
            this.formVisible = true;
        },
        async deleteResource(id) {
            this.$confirm.require({
                message     : this.__('Are you sure you want to delete this item?'),
                header      : this.__('Confirmation'),
                icon        : 'pi pi-exclamation-triangle',
                acceptLabel : this.__('Yes'),
                rejectLabel : this.__('No'),
                accept      : () => {
                    this.$inertia.delete(route('timesheets.destroy', id),
                        {
                            preserveScroll : true,
                            onSuccess      : () => {
                                this.$inertia.get(route('timesheets.index'));
                            },
                        }
                    );
                }
            });
        },
        async massDeleteResource() {
            this.$confirm.require({
                message     : this.__('Are you sure you want to delete all these items?'),
                header      : this.__('Confirmation'),
                icon        : 'pi pi-exclamation-triangle',
                acceptLabel : this.__('Yes'),
                rejectLabel : this.__('No'),
                accept      : () => {
                    this.$inertia.post(route('timesheets.massDestroy'), {
                            selected : this.selected,
                        },
                        {
                            preserveScroll : true,
                            onSuccess      : () => {
                                this.$inertia.get(route('timesheets.index'));
                            },
                        }
                    );
                },
            });
        },
    }
}
</script>
