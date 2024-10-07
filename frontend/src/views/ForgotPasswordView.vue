<template>
  <div class="forgot-password">
    <h1>Восстановление пароля</h1>
    <form @submit.prevent="sendResetLink">
      <div>
        <label for="email">Введите ваш email:</label>
        <input type="email" v-model="email" required />
      </div>
      <button type="submit">Отправить ссылку для сброса пароля</button>
    </form>
    <p v-if="message" :class="{'success': isSuccess, 'error': !isSuccess}">{{ message }}</p>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
  name: 'ForgotPassword',
  data() {
    return {
      email: '',
      message: '',
      isSuccess: false,
    };
  },
  methods: {
    async sendResetLink() {
      const toast = useToast();
      try {
        const response = await axios.post('/api/v1/auth/reset-password-request', { email: this.email });
        this.message = response.data.message || 'Ссылка для сброса пароля отправлена на ваш email!';
        this.isSuccess = true;
        this.email = ''; // Сбросить email
      } catch (error) {
        this.message = 'Ошибка при отправке запроса на сброс пароля.';
        this.isSuccess = false;
        toast.error(this.message);
      }
    },
  },
};
</script>

<style scoped>
.forgot-password {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 8px;
}

input {
  width: 100%;
  padding: 8px;
  margin-bottom: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  padding: 10px 20px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #38a169;
}

.success {
  color: green;
}

.error {
  color: red;
}
</style>
