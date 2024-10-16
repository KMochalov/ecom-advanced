<template>
  <breadcrumbs
    title="Профиль"
  ></breadcrumbs>
  <v-row justify="center" v-if="profile">
    <v-col
      cols="4">
    <v-card
        class="elevation-0 rounded-md"
    >
      <v-card-text class="mx-auto text-center">
        <v-avatar
            color="brown"
            size="200"
        >
          <v-icon>mdi-account</v-icon>
        </v-avatar>
        <v-divider class="mt-5 mb-5"></v-divider>
        <span class="mb-5 text-disabled"> загрузить/сменить аватар</span>
        <v-btn
          class="mt-5"
          color="info"
          @click="console.log('тут будет загрузка')"
        >
          загрузить аватар
        </v-btn>
      </v-card-text>
    </v-card>
    </v-col>
    <v-col
        cols="8"
    >
      <v-card class="elevation-0 rounded-md" >
        <v-card-text>
          <v-list >
            <v-list-item>
              <strong>Email:</strong> {{ profile.email }}
            </v-list-item>
            <v-list-item>
              <strong>ФИО:</strong> Костя Мочалов
            </v-list-item>
          </v-list>
          <v-divider></v-divider>
          <v-card-actions>
            <v-btn
              color="info"
              @click="console.log('change password')"
            >
              Именить пароль
            </v-btn>
            <v-btn
                color="info"
                @click="console.log('change email')"
            >
              Именить почту
            </v-btn>
          </v-card-actions>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';
import Breadcrumbs from "@/components/Breadcrumbs.vue";

export default {
  components: {Breadcrumbs},
  emits: ['authChanged'],
  data() {
    return {
      profile: null,
      isModalOpen: false,
      oldPassword: null,
      newPassword: null
    };
  },
  async created() {
      const token = localStorage.getItem('authToken');
      await axios.get('/api/v1/profile', {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }).then(response => {
        this.profile = response.data;
        console.log( this.profile)
      }).catch(error => {
        console.error('Ошибка при получении профиля:', error);
      });
  },
  methods: {
    openModal() {
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.oldPassword = '';
      this.newPassword = '';
    },
    async changePassword() {
      const toast = useToast();
      try {
        const token = localStorage.getItem('authToken');
        const response = await axios.post('/api/v1/auth/change-password', {
          userId: this.profile.user_id,
          old: this.oldPassword,
          new: this.newPassword
        }, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });
        toast.success(response.data.message || 'Пароль успешно изменен!');
        this.closeModal();
      } catch (error) {
        console.error('Ошибка при смене пароля:', error);
        toast.error(error.response.data.detail);
      }
    }
  },
};
</script>

<style scoped>

</style>
