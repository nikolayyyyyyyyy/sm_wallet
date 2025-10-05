<script setup>
import { ref } from 'vue';

const isAuthenticated = ref(localStorage.getItem('token') ? true : false);

const logout = async () => {
  await fetch('http://localhost:8000/api/logout', {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      'Authorization': `Bearer ${localStorage.getItem('token')}`
    }
  })
  localStorage.removeItem('token');
};
</script>

<template>
  <div>
    <nav class="nav">
      <RouterLink v-if="isAuthenticated" class="nav-item" to="/">Начало</RouterLink>
      <RouterLink v-if="!isAuthenticated" class="nav-item" to="/login">Вход</RouterLink>
      <RouterLink v-if="!isAuthenticated" class="nav-item" to="/register">Регистрация</RouterLink>
      <RouterLink v-if="isAuthenticated" @click="logout" class="nav-item" to="/login">Изход</RouterLink>
    </nav>
  </div>

  <RouterView />
</template>

<style scoped lang="scss">
.nav {
  display: flex;
  gap: 15px;
  background-color: #495867;
  padding: 15px 20px;

  .nav-item {
    padding: 5px;
    border-radius: 5px;
    background-color: var(--c-base);
    text-decoration: none;
    color: var(--c-white);
    font-family: var(--ff-base);
  }

  .nav-item:hover {
    background-color: var(--c-blue);
  }
}
</style>
