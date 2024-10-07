<template>
  <div>
    <h1>Личный кабинет</h1>
    <div v-if="profile">
      <p><strong>Имя:</strong> {{ profile.name || 'Не указано' }}</p>
      <p><strong>Фото:</strong>
        <img v-if="profile.photo" :src="profile.photo" alt="Фото пользователя" />
        <span v-else>Фото недоступно</span>
      </p>
      <p><strong>Email:</strong> {{ profile.email }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      profile: null,
    };
  },
  async created() {
    try {
      const token = localStorage.getItem('authToken');
      const response = await axios.get('/api/v1/profile', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      });
      this.profile = response.data;
    } catch (error) {
      console.error('Ошибка при получении профиля:', error);
    }
  },
};
</script>

<style scoped>
/* Добавьте стили по необходимости */
</style>
