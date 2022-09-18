<template>

  <Head title="Login"/>

  <div class="text-center mb-5">
    <img src="/images/blocks/logos/hyper.svg" alt="Image" height="50" class="mb-3">
    <div class="text-900 text-3xl font-medium mb-3">Two Factor Authentication</div>
    <div class="grid">
      <span class="col-12 text-600 font-medium line-height-3">Please enter the secret code to connect to this secure portal.</span>
      <span class="col-12 text-600 font-medium line-height-3">To request a new code: <a :class="countdown ? 'disabled' : ''" href="#" @click="generateCode()">{{ generateText }}</a></span>
    </div>
  </div>

  <ValidationErrors class="mb-4"/>
  <Message v-if="status" severity="info">{{ status }}</Message>

  <form @submit.prevent="submit">
    <label for="secret" class="block text-900 font-medium mb-2">Code</label>
    <InputText id="secret" v-model="form.secret" type="text" class="w-full mb-3" required/>

    <Button label="Confirm Code" :disabled="form.processing" type="submit" class="w-full"></Button>
  </form>

</template>

<script>
import GuestLayout from '@/Layouts/Guest.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default {
  layout : GuestLayout,

  components : {
    ValidationErrors,
    Head,
    Link,
  },

  props : {
    canResetPassword : Boolean,
    status           : String,
  },

  data() {
    return {
      form      : this.$inertia.form({
        secret : ''
      }),
      countdown : 0
    }
  },
  computed : {
    generateText() {
      return this.countdown === 0 ? 'Click here' : `Please wait (${this.countdown})`;
    }
  },
  watch    : {
    countdown(value) {
      if (value > 0) {
        setTimeout(() => {
          this.countdown--;
        }, 1000);
      }
    }
  },
  methods  : {
    submit() {
      this.form.post(this.route('2FA.validateSession'), {})
    },
    generateCode() {
      if (this.countdown > 0) {
        return;
      }
      this.$inertia.post(this.route('2FA.generateCode'))
      this.countdown = 60;
    }
  }
}
</script>
<style>
a.disabled {
  pointer-events : none;
  cursor         : default;
}
</style>