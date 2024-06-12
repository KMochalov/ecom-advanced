<template>
  <div>
    <form @submit.prevent="register">
      <div>
        <label for="email">Почтfdа:</label>
        <input type="email" v-model="email" required />
      </div>
      <div>
        <label for="password">Password:</label>
        <input type="password" v-model="password" required />
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('/api/v1/signup-request', {
          email: this.email,
          password: this.password
        });
        console.log('User registered successfully:', response.data);
        // Обработайте успешную регистрацию, например, сохраните токен или перенаправьте пользователя
      } catch (error) {
        console.error('Error registering user:', error.response.data);
        // Обработайте ошибку регистрации
      }
    }
  }
};
</script>
