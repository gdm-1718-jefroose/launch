<template> 
  <div class="row">
    <div class="col s12">
      <h5> MY RESERVATIONS </h5>
        <div class="col s12">
          <ul class="collection">
            <li class="collection-item avatar" v-for="reservation in reservations">
              <img class="circle" :src="reservation.field_imgvehicle[0].value" alt="Couch">
              <span class="title">{{reservation.field_namevehicle[0].value}}</span>
              <p><strong>From: </strong>{{ formatDate(reservation.field_from[0].value)}}</p>
              <p><strong>Until: </strong>{{ formatDate(reservation.field_until[0].value)}}</p>
              <div class="secondary-content">
                <a><i @click="deleteReservation(reservation)" class="material-icons right">delete</i></a>
                <router-link :to="{ name: 'reservation-edit', params: { reservationID: reservation.id[0].value }}" ><i class="material-icons right">edit</i></router-link>
                <span>
                  <i v-show="!reservation.field_paid[0].value"class="material-icons right">money_off</i>
                  <i v-show="reservation.field_paid[0].value"class="material-icons right">attach_money</i>
                </span>
              </div>
            </li>
          </ul>
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import router from '../router';
export default {
  name: 'my-reservations',
  data () {
    return {
      reservations: '',
      couchIds:'',
      vehicles: '',
      vehicleName: '',
      paid: ''
    }
  },
  created() {
    var uid = localStorage.getItem('uid');
    axios
      .get('http://localhost/api/reservations/user/' + uid)
      .then(({data: response})=> {
        this.reservations = response;
      })
      .catch(error => {
        console.info(error.message)
      })
  },
  methods: {
    deleteReservation(order) {
      
      var authHash = localStorage.getItem('auth')
      var auth = String(window.atob(authHash))
      var divider = auth.indexOf(':')
      var authUser = auth.substring(0, divider);
      var authPass = auth.substring(divider + 1, auth.length)

      var config = {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        auth: {
          username: authUser,
          password: authPass
        },
      };
      axios
        .delete('http://localhost/launch/reservation/' + order.id[0].value, config)
        .then(() => {
          router.go('/my-reservations');  
          console.log('verwijderd')
        })
        .catch((error) => {
          console.log(error);
        })
    },
    formatDate(date) {
      var data = new Date(date);
      var day = data.getDate();
      var month = data.getMonth() + 1;
      var year = data.getFullYear();

      return day + '/' + month + '/' + year; 
    },
  }

}
</script>
 