<template>
  <div id="app">
    <nav>
      <div class="nav-wrapper">
        <router-link to="/" class="brand-logo">Launch</router-link>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <div v-show="!user.authenticated">
            <li><router-link to="/login">Login</router-link></li>
            <li><router-link to="/register">Sign up</router-link></li>
          </div>
          <div v-show="user.authenticated">
            <li><a class="dropdown-trigger web-dropdown" href="#!" data-target="dropdown1">Hallo, {{user.name}}<i class="material-icons right">arrow_drop_down</i></a></li>
          </div>
        </ul>
        <ul class="sidenav" id="mobile-demo">
          <div v-show="!user.authenticated">
            <li><router-link to="/login">Login</router-link></li>
            <li><router-link to="/register">Sign up</router-link></li>
          </div>
          <div v-show="user.authenticated">
            <li><div class="user-view">
              <div class="background">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/ee/Lyons_Architects_Office.jpg">
              </div>
              <a href="#!user"><img class="circle" src="https://pbs.twimg.com/profile_images/920671362993311744/z-RnUyaI.jpg"></a>
              <a href="#!name"><span class="white-text name">Jef Roosens</span></a>
              <a href="#!email"><span class="white-text email">jef.roosens@gmail.com</span></a>
            </div></li>
            <li><router-link to='/profile' href="#!">Profile</router-link></li>
            <li><router-link to='/my-vehicles'>My vehicles</router-link></li>
            <li class="divider"></li>
            <li><a v-on:click="logout()">Logout</a></li>
          </div>
        </ul>
      </div>
      <ul id="dropdown1" class="dropdown-content">
        <li><router-link to='/profile' href="#!">Profile</router-link></li>
        <li><router-link to='/my-vehicles'>My vehicles</router-link></li>
        <li class="divider"></li>
        <li><a v-on:click="logout()">Logout</a></li>
      </ul>
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