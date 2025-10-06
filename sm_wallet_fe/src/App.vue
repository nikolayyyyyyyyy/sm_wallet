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
  background-color: var(--c-grayed);
  padding: 15px 20px;
  border-bottom: 1px solid #334155;

  .nav-item {
    padding: 5px;
    border-radius: 5px;
    background-color: var(--c-purple);
    text-decoration: none;
    color: var(--c-white);
    font-family: var(--ff-base);
    box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
  }

  .nav-item:hover {
    background-color: #6a29a6;
  }
}
</style>
