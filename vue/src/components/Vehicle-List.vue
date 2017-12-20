<template> 
  <div class="row">
    <div v-show="loading" class="progress">
      <div class="indeterminate"></div>
    </div>
    <ul class="collection">
      <li class="collection-item avatar" v-for="vehicle in vehicles">
        <img class="circle" v-bind:src="vehicle.field_image[0].url" v-bind:alt="vehicle.field_image[0].alt">
        <span class="title">{{ vehicle.name[0].value }}</span>
        <p><strong>Seats:</strong> {{ vehicle.field_seats[0].value }}</p>
        <p><strong>Licence:</strong> {{ vehicle.field_license[0].value }}</p>
        <p>
          <strong>Rating:</strong> 
          <span v-for="star in vehicle.field_rating[0].value">
            <i class="material-icons">star</i>
          </span>
        </p>
        <router-link :to="{ name: 'vehicle-detail', params: { vehicleID: vehicle.id[0].value }}" class="secondary-content"><i class="material-icons">forward</i></router-link>
      </li>
    </ul>
    <router-link to="/create" class="btn-floating btn-large waves-effect waves-light red right"><i class="material-icons">add</i></router-link>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'vehicle-list',
  data () {
    return {
      vehicles: '',
      loading: false
    }
  },
  created() {
      this.loading = true;
      axios
        .get('http://localhost/api/vehicles')
        .then(({data: response}) => {
          this.loading = false;
          this.vehicles = response;
        })
        .catch(error => {
          console.info(erro.message)
        })
  }
}
</script>
