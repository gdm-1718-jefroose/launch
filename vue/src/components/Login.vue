<template>
   <div class="row">
    <div class="container">
      <h3>Login</h3>
    </div>
    <form class="col m6 offset-m3 s12" v-on:submit="login">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" v-model="name" class="validate">
          <label for="name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" v-model="password" class="validate">
          <label for="password">Password</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Login
        <i class="material-icons right">send</i>
      </button>
      <router-link to="/register" class="btn waves-effect waves-dark right">Register<i class="material-icons right">directions_walk</i></router-link>
    </form>
  </div>
</template>

<script>
import auth from '../auth'
import axios from 'axios';
export default {
  name: 'login',
  data () {
    return {
      name: '',
      password: '',
      success: '',
      error: '',
      errorResponse: ''
    }
  },
  methods: {
    login: function(event){
      event.preventDefault();

      var credentials = {
        name: this.name,
        pass: this.password,
      }

      auth.login(this, credentials,'/');
    }
  }
}
</script>
