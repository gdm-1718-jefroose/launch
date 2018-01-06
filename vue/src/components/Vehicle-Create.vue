<template> 
  <div class="row">
    <form class="col s12" v-on:submit="addVehicle">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" v-model="name" class="validate">
          <label for="name">Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <select class="select-seats" v-model="seats">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
          <label>Seats</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="price" type="number" v-model="price" class="validate">
          <label for="price">price</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="battery" type="number" v-model="battery" class="validate">
          <label for="battery">battery</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="latitude" type="number" v-model="latitude" class="validate">
          <label for="latitude">latitude</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="longitude" type="number" v-model="longitude" class="validate">
          <label for="longitude">longitude</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12 ">
          <select class="select-rating" v-model="rating">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <label>Rating</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <select class="select-licence" v-model="license">
            <option value="AM">AM</option>
            <option value="A1">A1</option>
            <option value="A2">A2</option>
            <option value="A">A</option>
            <option value="B">B</option>
            <option value="BE">BE</option>
          </select>
          <label>Rating</label>
        </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Add
        <i class="material-icons right">send</i>
      </button>
    </form>
  </div>    
</template>

<script>
import axios from 'axios'
export default {
  name: 'vehicle-create',
  data () {
    return {
      name: '',
      seats: '',
      price: '',
      battery: '',
      rating: '',
      license: '',
      latitude: '',
      longitude: ''
    }
  },
  created() {
  },
  methods: {
    addVehicle: function(event){
      event.preventDefault();


      var newVehicle = [
        {
            "name": [
                {
                    "value": this.name
                }
            ],
            "status": [
                {
                    "value": true
                }
            ],
            "field_battery": [
                {
                    "value": this.battery
                }
            ],
            "field_latitude": [
                {
                    "value": this.latitude
                }
            ],
            "field_license": [
                {
                    "value": this.license
                }
            ],
            "field_longitude": [
                {
                    "value": this.longitude
                }
            ],
            "field_price": [
                {
                    "value": this.price
                }
            ],
            "field_seats": [
                {
                    "value": this.seats
                }
            ]
          }
        ]

      var auth = localStorage.getItem('auth');
      var csrf = localStorage.getItem('csrf_token');

      axios
        .post('http://localhost/entity/couch', newVehicle, {headers: {
          'Accept' : 'application/json',
          'Content-Type' : 'application/json',
          'Authorization': 'Basic ' + auth
        }})
        .then((response)=>{
          context.success = 'Addition successful';
          context.error = '';
        })
        .catch((error) => {
          var errorResponse = error.response.data.message;
          errorResponse = errorResponse.replace(/(?:\r\n|\r|\n)/g, '<br />');
          console.log(errorResponse);
        })


    }


  },
  mounted: function () {
    this.$nextTick(function () {
      var seats = document.querySelector('.select-seats');
      var rating = document.querySelector('.select-rating');
      var licence = document.querySelector('.select-licence');
      var instance3 = new M.Select(seats);
      var instance4 = new M.Select(rating);
      var instance5 = new M.Select(licence);
    })
  },
}
</script>
 