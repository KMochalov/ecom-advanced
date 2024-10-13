<template>
  <v-row>
    <v-col>
      <v-card
          width="550" class="mx-auto mt-5"
      >
        <v-card-title>
          <h1>Восстановление пароля</h1>
        </v-card-title>
        <v-card-text>
          <v-form ref="form">
            <v-text-field
                v-model="email"
                label="Email"
                prepend-inner-icon="mdi-account-circle"
                :rules="emailRules"
                required
            />
          </v-form>
          <v-card-actions>
            <v-btn
                @click="sendResetLink"
            >
              Отправить ссылку для сброса пароля
            </v-btn>
          </v-card-actions>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
  name: 'ForgotPassword',
  data() {
    return {
      email: '',
      message: '',
      emailRules: [
        value => {
          if (value) return true

          return 'Email - обязательно для заполнения'
        },
        value => {
          if (/.+@.+\..+/.test(value)) return true

          return 'Введен некорректный Email'
        },
      ],
      validationErrorMessage: '', // Состояние для сообщения об ошибке
    };
  },
  methods: {
    async sendResetLink() {
      const isValid = await this.$refs.form.validate();
      const toast = useToast();

      if (!isValid.valid) {
        this.validationErrorMessage = 'Ошибка валидации формы.'; // Устанавливаем сообщение об ошибке
        toast.error(this.validationErrorMessage);
        return; // Прекращаем выполнение, если форма не валидна
      }

      try {
        const response = await axios.post('/api/v1/auth/reset-password-request', { email: this.email });
        this.message = response.data.message || 'Ссылка для сброса пароля отправлена на ваш email!';
        this.email = ''; // Сбросить email
        this.$refs.form.resetValidation();
        toast.success(this.message);
      } catch (error) {
        this.message = 'Ошибка при отправке запроса на сброс пароля.';
        toast.error(this.message);
      }
    },
  },
};
</script>

<style scoped>

</style>
