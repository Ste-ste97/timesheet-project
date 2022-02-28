<template>
    <li>
        <!-- max depth 3 -->
        <NavLink :name="name" :icon="icon" :children="children" :href="route_name" v-has-permission="{props: $page.props, permissions: permissions?.split('|')}">
            <NavLink v-for="child,index in children" :name="child.name" :icon="child.icon" :href="child.route_name" :children="child.children" :key="index+child.name" v-has-permission="{props: $page.props, permissions: child.permissions?.split('|')}">
                <NavLink v-for="grandchild,index in child.children" :name="grandchild.name" :icon="grandchild.icon" :href="grandchild.route_name" :children="[]" :key="index+grandchild.name" v-has-permission="{props: $page.props, permissions: grandchild.permissions?.split('|')}"></NavLink>
            </NavLink>
        </NavLink>
    </li>
</template>

<script>
import NavLink from "@/Components/NavLink.vue";
export default {
    components:{
        NavLink
    },
    props:{
        name: String,
        icon: String,
        route_name: String,
        permissions: String,
        children: {
            type: Array,
            default: []
        }
    },
}
</script>
