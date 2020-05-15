<template>
  <div id="app">
    <div id="nav">
      <ul>
        <li v-for="route in routes" v-bind:key="route.path">
          <router-link :to="route.path">{{ route.name }}</router-link>
        </li>
      </ul>
    </div>
    <router-view/>
  </div>
</template>

<script>
import { routes } from '@/router';
console.log(routes);
export default {
  name: 'App',
  data() {
    return {
      routes
    };
  }
};
</script>

<style>
.tac {
  text-align: center;
}
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

h1 {
  text-align: center;
}

#nav ul {
  background: #ac8b60;
  border-radius: 4px;
  display: flex;
  flex-direction: row;
  justify-content: center;
  list-style: none;
  margin: 0;
  padding: 20px;
}

#nav ul li {
  margin-left: 20px;
}

#nav ul li:first-child {
  margin-left: 0;
}

#nav a {
  display: block;
  font-weight: bold;
  color: #404040;
  text-decoration: none;
}

#nav a.router-link-exact-active {
  color: #ffffff;
}
</style>
