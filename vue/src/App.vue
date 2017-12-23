<template>
  <div id="app">
    <nav>
      <div class="nav-wrapper">
        <router-link to="/" class="brand-logo">Launch</router-link>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><router-link to="/login" v-if="!user.authenticated">Login</router-link></li>
          <li><a v-if="user.authenticated" v-on:click="logout()">Hallo {{user.name}}, logout</a></li>
        </ul>
        <ul class="sidenav" id="mobile-demo">
          <li><router-link to="/login" v-if="!user.authenticated">Login</router-link></li>
          <li><a v-if="user.authenticated" v-on:click="logout()">Hallo {{user.name}}, logout</a></li>
        </ul>
      </div>
    </nav>

    <main>
      <router-view></router-view>
    </main>
            
  </div>
</template>


<script>
import auth from './auth'
export default {
  name: 'app',
  data(){
    return{
      user: auth.user,
    }
  },
  methods:{
    logout() {
      auth.logout()
    }
  }
}
</script>

<style lang="scss">
  @import 'assets/css/app.css';
</style>