<template>
  <Header />
  <main>
    <router-view />
  </main>
  <Footer />
</template>

<script>
import Footer from '@/components/Footer/Footer';
import Header from '@/components/Header/Header';

export default {
	name: 'App',
	components: {
		Header,
    Footer
	}
}
</script>

<style>
* {
  margin: 0px;
  color: #191919;
  font-family: 'Roboto', sans-serif;
  box-sizing: border-box !important;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;

  display: grid;
  grid-template-rows: 60px calc(100% - 100px) 40px;
  min-height: 100vh;
}

main {
  max-width: 1200px;
  margin: 20px auto;
  width: 100%;
  height: auto;
}

a {
  text-decoration: none;
}

ul {
  list-style: none;
  padding-left: 0px;
}
</style>
