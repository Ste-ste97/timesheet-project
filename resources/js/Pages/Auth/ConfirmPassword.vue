<template>
  <Head title="Confirm Password"/>

  <div class="text-center mb-5">
    This is a secure area of the application. Please confirm your password before continuing.
  </div>

  <ValidationErrors class="mb-4"/>
  <form>
    <label for="password" class="block text-900 font-medium mb-2">Password</label>
    <InputText id="password" v-model="form.password" type="password" class="w-full mb-3"/>
    <Button @click="submit" :disabled="form.processing" label="Reset Password" class="w-full"></Button>
  </form>
</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head} from '@inertiajs/inertia-vue3';

export default {
  layout : GuestLayout,

  components : {
    ValidationErrors,
    Head,
  },

  data() {
    return {
      form : this.$inertia.form({
        password : '',
      })
    }
  },

  methods : {
    submit() {
      this.form.post(this.route('password.confirm'), {
        onFinish : () => this.form.reset(),
      })
    }
  }
}
</script>
