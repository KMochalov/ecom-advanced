<script>
import axios from 'axios';
import {useToast} from "vue-toastification";

export default {
  name: "ConfirmEmailChangeView",
  data() {
    return {
      token: null,
      loading: true
    }
  },
  created() {
    this.token = this.$route.query.token
    console.log(this.token);
    const toast = useToast();
    axios.post('/api/v1/auth/change-email-confirm', {
      token: this.token
    }).then(() => {
      toast.success('почта успешно изменена!');
    }).catch(error => {
      const errorMessage = error.response?.data?.detail || 'Ошибка при изменении почты';
      toast.error(errorMessage);
    }).finally(() => {
      this.loading = false
      this.$router.push('/profile')
    });

  }
}
</script>

<template>
  <v-progress-circular
      v-if="loading"
      indeterminate
      class="d-flex mx-auto"
  ></v-progress-circular>
</template>

<style scoped>

</style>;