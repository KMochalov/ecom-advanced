<template>
  <div class="home">
    <h1>Добро пожаловать!</h1>
    <p v-if="isAuthenticated">
      Вы вошли в систему. Перейдите в <router-link to="/">личный кабинет</router-link>.
    </p>
    <p v-else>
      Пожалуйста, <router-link to="/registration">зарегистрируйтесь</router-link> или <router-link to="/login">войдите</router-link>.
    </p>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'HomeView',
  setup() {
    const isAuthenticated = ref(!!localStorage.getItem('authToken'));

    return { isAuthenticated };
  },
};
</script>

<style scoped>
.home {
  text-align: center;
  margin-top: 50px;
}

a {
  color: #42b983;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}
</style>