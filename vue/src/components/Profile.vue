<template>
  <div class="row">
    <div class="container">
      <h3>Profile of {{name}}</h3>
    </div>
    <form class="col m6 offset-m3 s12" >
      <div class="row">
        <div class="input-field col s12">
          <input id="name" placeholder="name" type="text" v-model="name"  class="validate">
          <label for="name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" placeholder="Email"  v-model="email" class="validate">
          <label for="email">Email</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Save
        <i class="material-icons right">save</i>
      </button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'register',
  data () {
    return {
      user: '',
      name: '',
      email: ''
    }
  },
  created() {
    var uid = localStorage.getItem('uid');
    var auth = localStorage.getItem('auth');
    var csrfToken = localStorage.getItem('csrf');
    axios
      .get('http://localhost/user/' + uid + '?_format=hal_json',{ headers: {"Authorization" : "Basic " + auth}})
      .then(({data: response}) => {
        this.user = response;
        this.name = this.user.name[0].value;
        this.email = this.user.mail[0].value;
      })
      .catch(error => {
        console.log(auth)
        console.info(error.message)
      })
  }
}
</script>
