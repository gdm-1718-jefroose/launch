<template> 
  <div class="row">
    <div v-show="loading" class="progress">
      <div class="indeterminate"></div>
    </div>
    <div class="col s12 m12" v-for="vehicleItem in vehicle">
      <div class="card">
        <div class="card-image">
          <img v-bind:src="vehicleItem.field_image[0].url" v-bind:alt="vehicleItem.field_image[0].alt">
          <span class="card-title">{{ vehicleItem.name[0].value }}</span>
          <router-link to="/" class="btn-floating halfway-fab waves-effect waves-light red"><i class="material-icons">edit</i></router-link>
        </div>
        <div class="card-content">
          <p><strong>Seats: </strong>{{ vehicleItem.field_seats[0].value }}</p>
          <p><strong>Licence: </strong>{{ vehicleItem.field_license[0].value }}</p>
          <p>
            <strong>Rating: </strong> 
            <span v-for="star in vehicleItem.field_rating[0].value">
              <i class="material-icons">star</i>
            </span>
          </p>
          <p><strong>Battery: </strong>{{ vehicleItem.field_battery[0].value }}%</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'vehicle-detail',
  data () {
    return {
      vehicle: '',
      loading: false
    }
  },
  created() {
      this.loading = true;
      axios
        .get('http://localhost/api/vehicle/' + this.$route.params.vehicleID)
        .then(({data: response}) => {
          this.loading = false;
          this.vehicle = response;
        })
        .catch(error => {
          console.info(error.message)
        })
  }
}
</script>
 