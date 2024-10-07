<template>
  <div class="reset-password">
    <h1>Сброс пароля</h1>
    <form @submit.prevent="resetPassword">
      <div>
        <label for="password">Новый пароль:</label>
        <input type="password" v-model="password" required />
      </div>
      <div>
        <label for="confirmPassword">Повторите пароль:</label>
        <input type="password" v-model="confirmPassword" required />
      </div>
      <button type="submit">Сбросить пароль</button>
    </form>
    <div v-if="error" class="error">{{ error }}</div>
  </div>
</template>

<script>
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  setup() {
    const route = useRoute();
    const router = useRouter();
    const toast = useToast();
    const password = ref('');
    const confirmPassword = ref('');
    const error = ref('');

    const resetPassword = async () => {
      error.value = '';

      if (password.value !== confirmPassword.value) {
        error.value = 'Пароли не совпадают';
        return;
      }

      const token = route.query.token;

      try {
        await axios.post('/api/v1/auth/reset-password-confirm', {
          token,
          password: password.value,
        });
        toast.success('Пароль успешно сброшен!');
        router.push('/'); // Редирект на главную страницу
      } catch (err) {
        toast.error(err.response.data.detail);
      }
    };

    return {
      password,
      confirmPassword,
      resetPassword,
      error,
    };
  },
};
</script>

<style scoped>
.reset-password {
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

.forgot-password-link {
  background-color: transparent;
  color: #42b983; /* Цвет текста для ссылки */
  text-decoration: underline;
  border: none;
  cursor: pointer;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>
