<template>

  <v-app>
    <v-app-bar :elevation="2">
      <template v-slot:prepend>
        <v-app-bar-nav-icon @click.stop="sideMenuRailed = !sideMenuRailed"></v-app-bar-nav-icon>
      </template>

      <v-app-bar-title>Название страницы?</v-app-bar-title>
      <v-btn
          v-if="!this.isAuthenticated"
          to="/login"
      >Вход
      </v-btn>
      <v-btn
          v-if="!this.isAuthenticated"
          to="/registration"
      >
        Регистрация
      </v-btn>
      <v-menu
          v-if="this.isAuthenticated"
          min-width="200px"
          rounded
      >
        <template v-slot:activator="{ props }">
          <v-btn
              icon
              v-bind="props"
          >
            <v-avatar
                color="brown"
                size="large"
            >
              <v-icon>mdi-account</v-icon>
            </v-avatar>
          </v-btn>
        </template>
        <v-card class="rounded-md">
          <v-card-text>
            <div class="mx-auto text-center">
              <h3>Полное имя</h3>
              <p class="text-caption mt-1">
                test@mail.ru
              </p>
              <v-divider class="my-3"></v-divider>

              <v-list class="text-left">
                <v-list-item
                    class="pl-0"
                    color="primary"
                    rounded="xl"
                >
                  <v-btn
                      variant="text"
                      prepend-icon="mdi-account"
                      to="/profile"
                  >
                    Личный кабинет
                  </v-btn>
                </v-list-item>
                <v-list-item
                    class="pl-0"
                    color="primary"
                    rounded="xl">
                  <v-btn
                      variant="text"
                      prepend-icon="mdi-logout"
                      @click="logout"
                  >Выход
                  </v-btn>
                </v-list-item>
              </v-list>
            </div>
          </v-card-text>
        </v-card>
      </v-menu>
    </v-app-bar>
    <v-main>
      <side-bar-menu
        :rail="sideMenuRailed"
        @railed="sideMenuRailed = !sideMenuRailed"
      >
      </side-bar-menu>
      <v-container
          class="page-wrapper mt-5 pt-1"
      >
        <router-view @authChanged="updateAuthStatus"></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>

import axios from "axios";
import SideBarMenu from "@/components/AppSideBarMenu.vue";

export default {
  name: 'App',
  components: {
    SideBarMenu,
  },
  data() {
    return {
      isAuthenticated: !!localStorage.getItem('authToken'),
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ],
      sideMenuRailed: true
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

<style>
.page-wrapper {

}
.rounded-md {
  border-radius: 12px !important;
}
</style>
