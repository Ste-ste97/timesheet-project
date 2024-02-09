<template>
    <Head title="Dashboard"/>
    <Toast :breakpoints="{'920px': {width: '100%', right: '0', left: '0'}}" position="bottom-right"/>
    <ConfirmDialog></ConfirmDialog>
    <div class="min-h-screen lg:flex lg:relative lg:static surface-ground">
        <SideBar class="sidebar-size"/>
        <div class="app-size min-h-screen flex flex-column relative flex-auto">
            <TopBar/>
            <div class="p-5 flex flex-column flex-auto">
                <slot/>
            </div>
        </div>
    </div>
</template>

<script>
import SideBar from "./Partials/SideBar.vue";
import TopBar from "./Partials/TopBar.vue";
import {Head} from "@inertiajs/vue3";

export default {
    components : {
        SideBar,
        Head,
        TopBar
    },
    data() {
        return {
            showingNavigationDropdown : false,
        }
    },
    updated() {
        if (this.$page.props.message && localStorage.getItem('message_fingerprint') !== this.$page.props.message.fingerprint) {
            this.$toast.add({severity : this.$page.props.message.type, detail : this.$page.props.message.message, life : 3000});
            localStorage.setItem('message_fingerprint', this.$page.props.message.fingerprint)
        }
    }
}
</script>

<style lang="scss">
@import '../../assets/styles/layout.scss';

@media (min-width: 1000px) {
    .sidebar-size {
        max-width: 25vw;
    }
    .app-size {
        width: 80vw;
    }
}
</style>
