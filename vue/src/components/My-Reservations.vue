<template> 
  <div class="row">
    <div class="col s12">
      <h5> MY RESERVATIONS </h5>
        <div class="col s12">
          <ul class="collection">
            <li class="collection-item avatar" v-for="reservation in reservations">
              <img class="circle" src="https://secure.img1-fg.wfcdn.com/im/69056323/resize-h299-p1-w299%5Ecompr-r85/3321/33218498/Patricia+Loveseat.jpg" alt="Couch">
              <span class="title">{{getVehicleName(reservation.field_couch[0].target_id)}}</span>
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

      var config = {
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json'
        },
        auth: {
          username: 'launch-user',
          password: 'launch-pass'
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
    getVehicleName(id) {
      axios
        .get('http://localhost/api/couch/' + id)
        .then(({data: response})=> {
          var name = response[0].name[0].value
        })
        
      return name;
    },
  }

}
</script>
 