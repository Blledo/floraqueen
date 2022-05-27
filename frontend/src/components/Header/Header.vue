<template>
  <header id="header">
    <nav>
      <router-link to="/product-list">Product List</router-link> |
      <router-link to="/product-form">New Product</router-link>
    </nav>
  </header>
</template>

<style>
#header {
  padding: 20px;
  border-bottom: 1px solid #f2f2f2;
}

#header a {
  font-weight: bold;
  color: #2c3e50;
}

#header a.router-link-exact-active {
  color: rgba(247, 135, 56, 1);
}

#header nav {
  max-width: 1200px;
  width: 100%;
  margin: 0 auto;
}
</style>
