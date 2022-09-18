<template>
  <Head title="Register"/>

  <div class="text-center mb-5">
    <img src="/images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
    <div class="text-900 text-3xl font-medium mb-3">Welcome Back</div>
    <span class="text-600 font-medium line-height-3">Already registered?</span>
    <Link href="/login" class="font-medium no-underline ml-2 text-blue-500 cursor-pointer">Login</Link>
  </div>

  <form @submit.prevent="submit" class="grid formgrid p-fluid">
    <div class="field mb-4 col-12">
      <FormField label="Name" name="name" v-model="form.name" type="text"/>
    </div>

    <div class="field mb-4 col-12">
      <FormField label="Email" name="email" v-model="form.email" type="text"/>
    </div>

    <div class="field mb-4 col-12">
      <FormField component="Password" label="Password" name="password" v-model="form.password"/>
    </div>

    <div class="field mb-4 col-12">
      <FormField component="Password" label="Confirm Password" name="password_confirm" v-model="form.password_confirmation" type="password"/>
    </div>

    <Button label="Register" :disabled="form.processing" type="submit" class="w-full"></Button>
  </form>

</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import FormField from "@/Components/FormField.vue"

export default {
  layout : GuestLayout,

  components : {
    Head,
    Link,
    FormField
  },

  data() {
    return {
      form : this.$inertia.form({
        name                  : '',
        email                 : '',
        password              : '',
        password_confirmation : '',
        terms                 : false,
      })
    }
  },

  methods : {
    submit() {
      this.form.post(this.route('register'), {
        onFinish : () => this.form.reset('password', 'password_confirmation'),
      })
    }
  }
}
</script>
