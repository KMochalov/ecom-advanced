<template>
  <v-row>
    <v-col>
      <v-card
          width="550" class="mx-auto mt-5"
      >
        <v-card-title>
          <h1>Сброс пароля</h1>
        </v-card-title>
        <v-card-text>
          <v-form ref="form">
            <v-text-field
                v-model="password"
                :type="showPassword ? 'text': 'password'"
                label="Новый пароль"
                required
                :rules="passwordRules"
                prepend-inner-icon="mdi-lock"
                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append-inner="showPassword = !showPassword"
            />
            <v-text-field
                v-model="confirmPassword"
                :type="showPassword ? 'text': 'password'"
                label="Повторите пароль"
                required
                :rules="passwordRules"
                prepend-inner-icon="mdi-lock"
                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append-inner="showPassword = !showPassword"
            />
          </v-form>
          <v-card-actions>
            <v-btn
                @click="resetPassword"
            >
              Сбросить пароль
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

export default {
  data() {
    return {
      password: '',
      confirmPassword: '',
      passwordRules: [
        value => !!value || 'Пароль - обязателен для заполнения',
        // (value) => (value && /\d/.test(value)) || 'At least one digit',
        // (value) => (value && /[A-Z]{1}/.test(value)) || 'At least one capital latter',
        // (value) => (value && /[^A-Za-z0-9]/.test(value)) || 'At least one special character',
        (value) => (value && value.length >= 5 ) || 'минимальная длина пароля - 5 цифр',
      ],
      validationErrorMessage: '', // Состояние для сообщения об ошибке
      showPassword: false, // Состояние для сообщения об ошибке
    };
  },
  methods: {
    async resetPassword() {
      this.error = '';

      const toast = useToast();
      const isValid = await this.$refs.form.validate();

      if (!isValid.valid) {
        this.validationErrorMessage = 'Ошибка валидации формы.'; // Устанавливаем сообщение об ошибке
        toast.error(this.validationErrorMessage);
        return; // Прекращаем выполнение, если форма не валидна
      }

      if (this.password !== this.confirmPassword) {
        toast.error('Пароли не совпадают');
        return;
      }

      const token = this.$route.query.token;

      try {
        console.log(token);
        await axios.post('/api/v1/auth/reset-password-confirm', {
          token,
          password: this.password,
        });
        toast.success('Пароль успешно сброшен!'); // Предполагается, что используете плагин для уведомлений
        await this.$router.push('/login'); // Редирект на главную страницу
      } catch (err) {
        toast.error(err.response.data.detail);
      }
    },
  },
};
</script>

<style scoped>
</style>
