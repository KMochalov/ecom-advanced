<template>
  <v-card
    width="400" class="mx-auto mt-5"
  >
    <v-card-title>
      <h1>Вход</h1>
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
            prepend-inner-icon="mdi-lock"
            :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append-inner="showPassword = !showPassword"
        />
      </v-form>
      <v-card-actions>
        <v-btn
            @click="login"
        >
          Вход
        </v-btn>
        <v-btn
          to="/forgot-password"
        >
          Забыли пароль?
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
  name: 'LoginView',
  emits: ['authChanged'], // Явно указываем, что компонент излучает событие authChanged
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
      validationErrorMessage: '', // Состояние для сообщения об ошибке
    };
  },
  methods: {
    async login() {
      const isValid = await this.$refs.form.validate();

      const toast = useToast();
      if (!isValid.valid) {
        this.validationErrorMessage = 'Ошибка валидации формы.'; // Устанавливаем сообщение об ошибке
        toast.error(this.validationErrorMessage);
        return; // Прекращаем выполнение, если форма не валидна
      }

      try {
        const response = await axios.post('/api/v1/login', {
          username: this.form.email,
          password: this.form.password,
        });

        if (response.data.token) {
          localStorage.setItem('authToken', response.data.token);
          axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
          this.$emit('authChanged', true);
          this.$router.push('/');
          toast.success('Вы успешно вошли в систему!');
        }
      } catch (error) {
        toast.error('Ошибка входа: неверный email или пароль');
        console.error(error);
      }
    },
  },
};
</script>

<style scoped>
</style>
