<template>
  <div>
    <nav class="nav">
      <RouterLink class="nav-item" to="/login">Вход</RouterLink>
      <RouterLink class="nav-item" to="/register">Регистрация</RouterLink>
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
