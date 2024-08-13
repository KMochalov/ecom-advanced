<template>
  <div>
    <p v-if="loading">Загрузка...</p>
    <p v-if="error">{{ error }}</p>
    <p v-if="success">{{ success }}</p>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  name: 'ConfirmView',
  setup(_, { emit }) {
    const toast = useToast();
    const router = useRouter();
    const route = useRoute();
    const loading = ref(true);
    const error = ref(null);
    const success = ref(null);

    onMounted(async () => {
      try {
        const token = route.query.token;
        if (!token) {
          throw new Error('Токен подтверждения отсутствует.');
        }

        const response = await axios.get(`/api/v1/signup-confirm?token=${token}`);

        if (response.status === 200) {
          success.value = 'Ваш аккаунт успешно подтвержден!';
          toast.success('Вы успешно вошли в систему!');

          // Сохранение токена в localStorage
          localStorage.setItem('authToken', response.data.token);

          // Установка заголовка Authorization по умолчанию
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

          // Обновление состояния isAuthenticated вручную
          emit('authChanged', true);

          // Перенаправление на главную страницу
          router.push('/');
        }
      } catch (err) {
        error.value = err.response?.data?.message || 'Ошибка подтверждения регистрации. Пожалуйста, попробуйте снова.';
        toast.error(error.value);
      } finally {
        loading.value = false;
      }
    });

    return {loading, error, success};
  }
};
</script>
