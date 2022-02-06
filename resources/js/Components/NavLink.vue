<template>
        <li v-if="children.length>0">
            <a v-ripple class="flex align-items-center cursor-pointer p-3 hover:bg-bluegray-900 border-round text-bluegray-100 hover:text-bluegray-50
                transition-duration-150 transition-colors p-ripple"
                v-styleclass="{ selector: '@next', enterClass: 'hidden', enterActiveClass: 'slidedown', leaveToClass: 'hidden', leaveActiveClass: 'slideup' }">
                <i :class="['mr-2', icon]"></i>
                <span class="font-medium">{{ name }}</span>
                <i v-if="children.length > 0" class="pi pi-chevron-down ml-auto"></i>
            </a>
            <ul class="list-none py-0 pl-3 pr-0 m-0 hidden overflow-y-hidden transition-all transition-duration-400 transition-ease-in-out">
                <li>
                    <slot />
                </li>
            </ul>
        </li>
        <li v-else>
            <Link v-ripple class="no-underline flex align-items-center cursor-pointer p-3 hover:bg-bluegray-900 border-round text-bluegray-100 hover:text-bluegray-50
                transition-duration-150 transition-colors p-ripple"
                :href="href"
                >
                <i :class="['mr-2', icon]"></i>
                <span class="font-medium">{{ name }}</span>
            </Link>
        </li>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components:{
        Link
    },
    props:{
        name: String,
        icon: String,
        href: String,
        children: {
            type: Array,
            default: []
        }
    },
}
</script>
