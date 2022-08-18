<template>
  <div class="card">
    <div class="grid">Todo add notifications</div>
  </div>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
  layout: AuthenticatedLayout,
  components: {
    AuthenticatedLayout,
    Head,
  },
};
</script>
