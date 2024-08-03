<template>
  <div class="home">
    <h1>Добро пожаловать</h1>
    <p>Пожалуйста <router-link to="/registration">зарегистрируйтесь</router-link> или войдите</p>
  </div>
</template>

<script>
export default {
  name: 'HomeView',
};
</script>

<style scoped>
.home {
  margin-top: 50px;
}

h1 {
  font-size: 2.5em;
  margin-bottom: 20px;
  color: #2c3e50;
}

p {
  font-size: 1.2em;
  color: #34495e;
}
</style>