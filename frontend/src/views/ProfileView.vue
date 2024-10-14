<template>
  <h1>Профиль</h1>
  <v-row justify="center">
    <v-col
      cols="4">
    <v-card
    >
      <v-card-text class="mx-auto text-center">
        <v-avatar
            color="brown"
            size="100"
        >
          <v-icon>mdi-account</v-icon>
        </v-avatar>
      </v-card-text>
    </v-card>
    </v-col>
    <v-col
        cols="8"
    >

    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios';
import { useToast } from 'vue-toastification';

export default {
  data() {
    return {
      profile: null,
      oldPassword: '',
      newPassword: '',
      isModalOpen: false,
    };
  },
  setup() {
    const toast = useToast();
    return { toast };
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
        this.toast.success(response.data.message || 'Пароль успешно изменен!');
        this.closeModal();
      } catch (error) {
        console.error('Ошибка при смене пароля:', error);
        this.toast.error(error.response.data.detail);
      }
    }
  }
};
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal {
  background: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  width: 400px;
  max-width: 90%; /* Ограничение ширины для мобильных устройств */
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input {
  padding: 10px;
  width: calc(100% - 20px); /* Учитываем отступы */
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-actions {
  display: flex;
  justify-content: space-between;
}

.btn {
  padding: 10px 15px;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn:hover {
  background-color: #36a76e;
}

.cancel {
  background-color: #e74c3c;
}

.cancel:hover {
  background-color: #c0392b;
}
</style>
