<template>
  <div class="surface-card shadow-2 border-round p-4">
    <h4>{{notification.data.title}}</h4>
    <p>{{notification.data.message}}</p>
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
  props: {
    notification: Object
  }
};
</script>
