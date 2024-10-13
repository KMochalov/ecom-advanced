<template>
  <v-card
      width="400" class="mx-auto mt-5"
  >
    <v-card-title>
      <h1>Регистрация</h1>
    </v-card-title>
    <v-card-text>
      <v-form ref="form">
        <v-text-field
            v-model="form.email"
            label="Email"
            prepend-inner-icon="mdi-account-circle"
            :rules="emailRules"
            required
        />
        <v-text-field
            v-model="form.password"
            :type="showPassword ? 'text': 'password'"
            label="Пароль"
            required
            :rules="passwordRules"
            prepend-inner-icon="mdi-lock"
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showPassword = !showPassword"
        />
      </v-form>
      <v-card-actions>
        <v-btn
            @click="register"
        >
          Регистрация
        </v-btn>
      </v-card-actions>
    </v-card-text>
  </v-card>
  <v-form>

  </v-form>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";

export default {
  name: 'RegistrationView',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      showPassword: false,
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
      passwordRules: [
        value => !!value || 'Пароль - обязателен для заполнения',
        // (value) => (value && /\d/.test(value)) || 'At least one digit',
        // (value) => (value && /[A-Z]{1}/.test(value)) || 'At least one capital latter',
        // (value) => (value && /[^A-Za-z0-9]/.test(value)) || 'At least one special character',
        (value) => (value && value.length >= 5 ) || 'минимальная длина пароля - 5 цифр',
      ],
      validationErrorMessage: '', // Состояние для сообщения об ошибке
      error: null,
    };
  },
  methods: {
    async register() {
      const isValid = await this.$refs.form.validate();

      const toast = useToast();
      if (!isValid.valid) {
        this.validationErrorMessage = 'Ошибка валидации формы.'; // Устанавливаем сообщение об ошибке
        toast.error(this.validationErrorMessage);
        return; // Прекращаем выполнение, если форма не валидна
      }
      try {
        this.error = null;
        const response = await axios.post('/api/v1/signup-request', this.form);
        if (response.status === 201) {
          toast.success('Запрос на регистрацию отправлен! Проверьте указанную почту');
          this.$router.push('/');
        }
      } catch (error) {
        const errorMessage = error.response?.data?.detail || 'Ошибка запроса на регистрацию. Пожалуйста, попробуйте снова.';
        toast.error(`Ошибка запроса на регистрацию: ${errorMessage}`);
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
</style>