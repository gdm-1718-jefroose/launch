<template>
  <div class="row">
    <div class="container">
      <h5>Profile of {{name}}</h5>
    </div>
    <form class="col m6 offset-m3 s12" >
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" placeholder="name" v-model="name"  class="validate">
          <label class="active" for="name">Username</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" placeholder="Email"  v-model="email" class="validate">
          <label  class="active" for="email">Email</label>
        </div>
      </div>
      <!--<div class="row">
        <div class="input-field col s5">
          <input id="firstname" type="text" v-model="firstName" class="validate">
          <label class="active" for="firstname">First Name</label>
        </div>
        <div class="input-field col s7">
          <input id="lastname" type="text" v-model="lastName" class="validate">
          <label class="active" for="lastname">Last Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="street" type="text" v-model="street" class="validate">
          <label class="active" for="street">Street</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s4">
          <input id="postalcode" type="text" v-model="postalCode" class="validate">
          <label class="active" for="postalcode">Postal Code</label>
        </div>
        <div class="input-field col s8">
          <input id="city" type="text" v-model="city" class="validate">
          <label class="active" for="city">City</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="country" type="text" v-model="country" class="validate">
          <label class="active" for="country">Country</label>
        </div>
      </div>-->
      <button class="btn waves-effect waves-light blue lighten-1 col s12" type="submit" name="action">Save
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
      email: '',
      firstName: '',
      lastName: '',
      street: '',
      postalCode: '',
      city: '',
      country: ''
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
        this.firstName = this.user.field_first_name[0].value;
        this.lastName = this.user.field_last_name[0].value;
        this.street = this.user.field_street_address[0].value;
        this.postalCode = this.user.field_postal_[0].value;
        this.city = this.user.field_city[0].value;
        this.country = this.user.field_country[0].value;
      })
      .catch(error => {
        console.info(error.message)
      })
  },
  methods: {
    
  }
}
</script>
