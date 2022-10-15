<template>
    <li>
        <NavLink v-has-permission="{props: $page.props, permissions: permissions?.split('|')}" :children="children" :href="route_name" :icon="icon" :name="name">
            <NavLink v-for="(child,index) in children" :key="index+child.name" v-has-permission="{props: $page.props, permissions: child.permissions?.split('|')}" :children="child.children" :href="child.route_name" :icon="child.icon"
                     :name="child.name">
                <NavLink v-for="(grandchild,index) in child.children" :key="index+grandchild.name" v-has-permission="{props: $page.props, permissions: grandchild.permissions?.split('|')}" :children="[]" :href="grandchild.route_name" :icon="grandchild.icon"
                         :name="grandchild.name"></NavLink>
            </NavLink>
        </NavLink>
    </li>
</template>

<script>
import NavLink from "@/Components/NavLink.vue";

export default {
    components : {
        NavLink
    },
    props      : {
        name        : String,
        icon        : String,
        route_name  : String,
        permissions : String,
        children    : {
            type    : Array,
            default : []
        }
    },
}
</script>
