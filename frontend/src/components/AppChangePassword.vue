<template>
      <v-btn
          color="info"
          @click="changePasswordDialog = true"
      >Изменить пароль</v-btn>
      <v-dialog
          v-model="changePasswordDialog"
          max-width="500"
      >
        <template v-slot:default>
          <v-form ref="form">
            <v-card
                width="550" class="mx-auto mt-5"
            >
              <v-card-title>
                <h1>Изменить пароль</h1>
              </v-card-title>
              <v-card-text>
                <v-text-field
                    v-model="oldPassword"
                    :type="showPasswordOld ? 'text': 'password'"
                    label="Старый пароль"
                    required
                    prepend-inner-icon="mdi-lock"
                    :append-inner-icon="showPasswordOld ? 'mdi-eye' : 'mdi-eye-off'"
                    @click:append-inner="showPasswordOld = !showPasswordOld"
                />
                <v-divider class="mb-5"></v-divider>

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
                <v-card-actions>
                  <v-btn
                      @click="changePassword"
                      color="info"
                  >
                    Изменить пароль
                  </v-btn>
                </v-card-actions>
              </v-card-text>
            </v-card>
          </v-form>
        </template>
      </v-dialog>

</template>

<script>

import {useToast} from "vue-toastification";
import axios from "axios";

export default {
  props:['profile'],
  data() {
    return {
        oldPassword: '',
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
        showPasswordOld: false, // Состояние для сообщения об ошибке
        changePasswordDialog: false,
    }
  },
  methods: {
    async changePassword() {
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

      await axios.post('/api/v1/auth/change-password', {
        userId: this.profile.user_id,
        old: this.oldPassword,
        new: this.password,
      }).then(
          () => {
            toast.success('Пароль изменен!');
            this.oldPassword = null;
            this.password = null;
            this.confirmPassword = null;
            this.changePasswordDialog = false
          }
      ).catch(err => {
        toast.error(err.response.data.detail);
      })
    },
  }
}

</script>

<style scoped>

</style>