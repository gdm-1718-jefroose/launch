<template>
  <div class="row">
    <div class="container">
      <h3>My vehicles</h3>
      <p>This feature will be up soon</p>
    </div>
    <ul class="collection">
      <li class="collection-item avatar" v-for="vehicle in vehicles" v-show="vehicle.user_id[0].target_id == uid">
        <div>
          <img class="circle" src="https://secure.img1-fg.wfcdn.com/im/69056323/resize-h299-p1-w299%5Ecompr-r85/3321/33218498/Patricia+Loveseat.jpg" alt="Couch">
          <span class="title">{{ vehicle.name[0].value }}</span>
          <p><strong>Seats:</strong> {{ vehicle.field_seats[0].value }}</p>
          <p><strong>Licence:</strong> {{ vehicle.field_license[0].value }}</p>
          <p>
            <strong>Rating:</strong> 
              <i class="material-icons">star</i>
            </span>
          </p>
          <router-link :to="{ name: 'vehicle-detail', params: { vehicleID: vehicle.id[0].value }}" class="secondary-content"><i class="material-icons">forward</i></router-link>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'my-vehicles',
  data () {
    return {
      vehicles: '',
      uid: ''
    }
  },
  created (){
    this.uid = localStorage.getItem('uid');
    axios
    .get('http://localhost/api/couches')
    .then(({data: response}) => {
      this.vehicles = response;
      console.log(this.vehicles[0].user_id[0].target_id);
    })
    .catch(error => {
      console.info(error.message)
    })
  }
}
</script>
