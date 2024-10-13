<template>
  <v-app>
    <v-app-bar :elevation="2">
      <template v-slot:prepend>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
      </template>

      <v-app-bar-title>Название страницы?</v-app-bar-title>
      <v-btn
          v-if="!this.isAuthenticated"
          to="/login"
      >Вход
      </v-btn>
      <v-btn
          v-else
          @click="logout"
      >Выход
      </v-btn>
      <v-btn
        v-if="!this.isAuthenticated"
        to="/registration"
      >
        Регистрация
      </v-btn>
      <v-btn
          v-if="this.isAuthenticated"
          to="/profile"
      >
        Личный кабинет
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-container>
        <router-view @authChanged="updateAuthStatus"></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>

import axios from "axios";

export default {
  name: 'App',
  data() {
    return {
      isAuthenticated: !!localStorage.getItem('authToken'),
    };
  },
  methods: {
    updateAuthStatus(value) {
      this.isAuthenticated = value;
    },
    logout() {
      localStorage.removeItem('authToken');
      delete axios.defaults.headers.common['Authorization'];
      this.isAuthenticated = false;
      this.$router.push('/');
    },
  },
  watch: {
    isAuthenticated: {
      handler(newValue) {
        if (newValue) {
          axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('authToken')}`;
        }
      },
      immediate: true,
    },
  },
};
</script>
