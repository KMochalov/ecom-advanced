<template>
  <v-btn
      color="info"
      @click="changeEmailDialog = true"
  >Изменить почту</v-btn>
  <v-dialog
      v-model="changeEmailDialog"
      max-width="500"
  >
    <template v-slot:default>
      <v-form ref="form">
        <v-card
            width="550" class="mx-auto mt-5"
        >
          <v-card-title>
            <h1>Изменить почту</h1>
          </v-card-title>
          <v-card-text>
            <v-text-field
                v-model="newEmail"
                label="Новый Email"
                required
                :rules="emailRules"
            />
            <v-divider class="mb-5"></v-divider>
            <v-card-actions>
              <v-btn
                  @click="changeEmail"
                  color="info"
              >
                Изменить
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
      newEmail: '',
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
      changeEmailDialog: false,
    }
  },
  methods: {
    async changeEmail() {
      this.error = '';

      const toast = useToast();
      const isValid = await this.$refs.form.validate();

      if (!isValid.valid) {
        this.validationErrorMessage = 'Ошибка валидации формы.'; // Устанавливаем сообщение об ошибке
        toast.error(this.validationErrorMessage);
        return; // Прекращаем выполнение, если форма не валидна
      }

      await axios.post('/api/v1/auth/change-email-request', {
        userId: this.profile.user_id,
        newEmail: this.newEmail,
      }).then(
          () => {
            toast.success('Вам на почту отпрвлено письмо со ссылкой для смены пароля');
            this.newEmail = null
            this.changeEmailDialog = false

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