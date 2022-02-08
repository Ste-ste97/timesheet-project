<template>
    <li>
        <!-- max depth 3 -->
        <NavLink :name="name" :icon="icon" :children="children" :href="route_name">
            <NavLink v-for="child,index in children" :name="child.name" :icon="child.icon" :href="child.route_name" :children="child.children" :key="index+child.name">
                <NavLink v-for="grandchild,index in child.children" :name="grandchild.name" :icon="grandchild.icon" :href="grandchild.route_name" :children="[]" :key="index+grandchild.name"></NavLink>
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
        children: {
            type: Array,
            default: []
        }
    },
}
</script>
