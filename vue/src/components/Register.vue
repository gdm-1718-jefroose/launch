<template>
  <div class="row">
    <div class="container">
      <h3>Register</h3>
    </div>
    <form class="col m6 offset-m3 s12" v-on:submit="register">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" v-model="name" class="validate">
          <label for="name">Enter username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" v-model="email" class="validate">
          <label for="email">Enter email</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password" type="password" v-model="password" class="validate">
          <label for="password">Enter password</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="password2" type="password" v-model="password2" class="validate">
          <label for="password2">Enter password again</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Register
        <i class="material-icons right">send</i>
      </button>
    </form>
  </div>
</template>

<script>
import auth from '../auth'
export default {
  name: 'register',
  data () {
    return {
      name: '',
      email: '',
      password: '',
      password2: '',
      success: '',
      error: '',
    }
  },
  methods: {
    register: function(event){
      event.preventDefault();

      if (this.password != this.password2){
        this.success = '';
        this.error = 'Passwords do not match';
        return;
      }

      var credentials = {
          name: [{"value": this.name}],
          mail: [{"value": this.email}],
          pass: [{"value": this.password}]
      }

      auth.signup(this, credentials, '/');
    }
  }
}
</script>
