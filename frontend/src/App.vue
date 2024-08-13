<template>
  <div class="app">
    <nav>
      <router-link to="/">Главная</router-link> |
      <router-link v-if="!isAuthenticated" to="/registration">Регистрация</router-link>
      <router-link v-if="!isAuthenticated" to="/login">Вход</router-link>
      <button v-if="isAuthenticated" @click="logout">Выход</button>
    </nav>
    <router-view @authChanged="handleAuthChanged"/>
  </div>
</template>

<script>
import { ref, watchEffect } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  setup() {
    const isAuthenticated = ref(!!localStorage.getItem('authToken'));
    const router = useRouter();

    const logout = () => {
      localStorage.removeItem('authToken');
      delete axios.defaults.headers.common['Authorization'];
      isAuthenticated.value = false;
      router.push('/');
    };

    const handleAuthChanged = (authStatus) => {
      isAuthenticated.value = authStatus;
      if (authStatus) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('authToken')}`;
      }
    };

    watchEffect(() => {
      isAuthenticated.value = !!localStorage.getItem('authToken');
      if (isAuthenticated.value) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('authToken')}`;
      }
    });

    return { isAuthenticated, logout, handleAuthChanged };
  }
};
</script>

<style scoped>
.app {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
}

nav {
  margin-bottom: 20px;
}

a, button {
  margin: 0 10px;
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
</style>