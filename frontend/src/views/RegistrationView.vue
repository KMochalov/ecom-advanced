<template>
  <div class="registration">
    <h1>Регистрация</h1>
    <form @submit.prevent="register">
      <div>
        <label for="email">Email:</label>
        <input type="email" v-model="form.email" required>
      </div>
      <div>
        <label for="password">Пароль:</label>
        <input type="password" v-model="form.password" required>
      </div>
      <button type="submit">Зарегистрироваться</button>
    </form>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
  name: 'RegistrationView',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      error: null,
    };
  },
  setup() {
    const toast = useToast();
    return { toast };
  },
  methods: {
    async register() {
      try {
        this.error = null;
        const response = await axios.post('/api/v1/signup-request', this.form);
        if (response.status === 201) {
          this.toast.success('Запрос на регистрацию отправлен! Проверьте указанную почту');
          this.$router.push('/');
        }
      } catch (error) {
        const errorMessage = error.response?.data?.detail || 'Ошибка запроса на регистрацию. Пожалуйста, попробуйте снова.';
        this.toast.error(`Ошибка запроса на регистрацию: ${errorMessage}`);
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
.registration {
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

.error {
  margin-top: 20px;
  color: red;
  font-weight: bold;
}
</style>