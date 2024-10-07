<template>
  <div class="login">
    <h1>Вход</h1>
    <form @submit.prevent="login">
      <div>
        <label for="email">Email:</label>
        <input type="email" v-model="form.email" required />
      </div>
      <div>
        <label for="password">Пароль:</label>
        <input type="password" v-model="form.password" required />
      </div>
      <button type="submit">Войти</button>
      <router-link to="/forgot-password" class="reset-password">Забыл пароль?</router-link>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
  name: 'LoginView',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    async login() {
      const toast = useToast();
      try {
        const response = await axios.post('/api/v1/login', {
          username: this.form.email,
          password: this.form.password,
        });

        if (response.data.token) {
          localStorage.setItem('authToken', response.data.token);
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
          this.$emit('authChanged', true);
          this.$router.push('/');
          toast.success('Вы успешно вошли в систему!');
        }
      } catch (error) {
        toast.error('Ошибка входа: неверный email или пароль');
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
.login {
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
  margin-right: 10px; /* Отступ между кнопками */
}

button:hover {
  background-color: #38a169;
}

.reset-password {
  background-color: transparent;
  color: #42b983;
  text-decoration: underline;
  border: none;
  cursor: pointer;
}

</style>
