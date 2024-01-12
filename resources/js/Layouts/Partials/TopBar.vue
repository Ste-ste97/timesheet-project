<template>
    <div class="flex justify-content-between align-items-center px-5 surface-section shadow-2 relative lg:static border-bottom-1 surface-border" style="height:60px">
        <div class="flex">
            <a v-ripple class="cursor-pointer block lg:hidden text-700 mr-3 mt-1 p-ripple"
               v-styleclass="{ selector: '#app-sidebar-2', enterClass: 'hidden', enterActiveClass: 'fadeinleft', leaveToClass: 'hidden', leaveActiveClass: 'fadeoutleft', hideOnOutsideClick: true}">
                <i class="pi pi-bars text-4xl"></i>
            </a>
            <span class="p-input-icon-left">
                <i class="pi pi-search"></i>
                <InputText type="text" class="border-none w-10rem sm:w-20rem" placeholder="Search"/>
            </span>
        </div>
        <a v-ripple class="cursor-pointer block lg:hidden text-700 p-ripple"
           v-styleclass="{ selector: '@next', enterClass: 'hidden', enterActiveClass: 'fadein', leaveToClass: 'hidden', leaveActiveClass: 'fadeout', hideOnOutsideClick: true }">
            <i class="pi pi-ellipsis-v text-2xl"></i>
        </a>
        <ul class="list-none p-0 m-0 hidden lg:flex lg:align-items-center select-none lg:flex-row
            surface-section border-1 lg:border-none surface-border right-0 top-100 z-1 shadow-2 lg:shadow-none absolute lg:static">
            <AppLocale/>
            <li>
                <Link :href="route('notifications.index')"
                      v-ripple class="flex p-3 lg:px-3 lg:py-2 align-items-center text-600 hover:text-900 hover:surface-100 font-medium border-round cursor-pointer
                    transition-duration-150 transition-colors p-ripple">
                    <i v-if="$page.props.auth.hasUnreadNotifications" class="pi pi-inbox text-base lg:text-2xl mr-2 lg:mr-0 " v-badge.danger></i>
                    <i v-else class="pi pi-inbox text-base lg:text-2xl mr-2 lg:mr-0 "></i>
                    <span class="block lg:hidden font-medium">Inbox</span>
                </Link>
            </li>
            <li class="border-top-1 surface-border lg:border-top-none">
                <a @click="toggle" v-ripple class="flex p-3 lg:px-3 lg:py-2 align-items-center hover:surface-100 font-medium border-round cursor-pointer
                    transition-duration-150 transition-colors p-ripple">
                    <img :src="genericAvatar" class="mr-3 lg:mr-0" style="width: 32px; height: 32px" alt="avatar"/>
                    <div class="block lg:hidden">
                        <div class="text-900 font-medium">{{ $page.props.auth.user.name }}</div>
                        <span class="text-600 font-medium text-sm">{{ $page.props.auth.user.email }}</span>
                    </div>
                </a>
            </li>
            <Menu ref="profileMenu" :popup="true" :model="profileItems"/>

        </ul>
    </div>
</template>

<script>
import {Link} from '@inertiajs/vue3'
import genericAvatar from '/resources/images/blocks/avatars/circle/generic_avatar.png';
import AppLocale from '@/Components/AppLocale.vue';

export default {
    components : {
        Link,
        AppLocale
    },
    data() {
        return {
            profileItems : [
                {
                    label   : 'Profile',
                    icon    : 'pi pi-user',
                    command : () => {
                        this.$inertia.visit(route('profile'))
                    }
                },
                {
                    label   : 'Sign out',
                    icon    : 'pi pi-sign-out',
                    command : () => {
                        this.$inertia.visit(route('logout'))
                    }
                },
            ],
            genericAvatar,
        }
    },
    methods : {
        toggle(event) {
            this.$refs.profileMenu.toggle(event);
        }
    }
}
</script>
