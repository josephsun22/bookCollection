<!-- <template>
  <div id="app">
    <img alt="Vue logo" src="./assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
import HelloWorld from './components/HelloWorld.vue'

export default {
  name: 'App',
  components: {
    HelloWorld
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style> -->

<template>
  <div id="app">
    <nav class="navbar">
      <div class="nav-links">
        <router-link to="/" class="nav-link">List All Books</router-link>
        <router-link to="/add" class="nav-link">Add Book</router-link>
      </div>
      <div class="hamburger" @click="toggleMenu">
        <div class="line" v-for="n in 3" :key="n"></div>
      </div>
    </nav>
    <div :class="['menu', { 'menu-active': isMenuActive }]">
      <router-link to="/" class="menu-link" @click="toggleMenu">List All Books</router-link>
      <router-link to="/add" class="menu-link" @click="toggleMenu">Add Book</router-link>
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      isMenuActive: false
    };
  },
  methods: {
    toggleMenu() {
      this.isMenuActive = !this.isMenuActive;
    }
  }
};
</script>


<style scoped>
body {
  margin: 0;
  font-family: Arial, sans-serif;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #007bff;
  padding: 10px 20px;
  color: white;
}

.nav-links {
  display: flex;
}

.nav-link {
  color: white;
  text-decoration: none;
  margin-right: 20px;
  transition: color 0.3s;
}

.nav-link:hover {
  color: #ffdd57;
}

.hamburger {
  display: none;
  flex-direction: column;
  justify-content: space-around;
  cursor: pointer;
  height: 20px;
  width: 25px;
}

.hamburger .line {
  background-color: white;
  height: 3px;
  width: 100%;
  border-radius: 2px;
}

.menu {
  display: none;
  flex-direction: column;
  background-color: #007bff;
  padding: 10px;
}

.menu-active {
  display: flex;
}

.menu-link {
  color: white;
  text-decoration: none;
  padding: 10px 0;
  transition: color 0.3s;
}

.menu-link:hover {
  color: #ffae57;
}

@media (max-width: 768px) {
  .nav-links {
    display: none;
  }

  .hamburger {
    display: flex;
  }
}
</style>

