<template> 
  <div class="row">
    <div class="col s12">
      <h5 class="center"> MAKE RESERVATION </h5>
      <div class="row">
        <div class="col s12">
          <div class="card">
            <div class="card-image">
              <img :src="vehicleImage" alt="couch">
              <span class="card-title blue lighten-1">{{ vehicleName }}</span>
            </div>
          </div>
        </div>
      </div>
      <form class="card-panel" v-on:submit="addReservation">
        <div class="row">
          <div class="input-field col s12">
            <input id="from" type="text" class="datepicker-from" ref="from" v-on:change="refreshFrom" required>
            <label for="from">From</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="until" type="text" class="datepicker-until" ref="until" v-on:change="refreshUntil" required>
            <label for="until">Until</label>
          </div>
        </div>
        <div class="row">
          <div class="col s6">
            <p>Days: <span>{{dateDifference}}</span></p>
          </div>
          <div class="col s6">
            <p>Price: €<span>{{totalPrice}}</span></p>
          </div>
        </div>
        <div class="row">
          <div class="col s12">
            <button class="btn waves-effect waves-light blue lighten-1" type="submit" name="action">Reserve
              <i class="material-icons right">send</i>
            </button>
          </div>
        </div>
      </form>
      <blockquote>
        This vehicle is unavailable in the following periods
      </blockquote>
      <table>
        <thead>
          <tr>
              <th>From</th>
              <th>Until</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="reservation in reservations">
            <td>{{formatDate(reservation.field_from[0].value)}}</td>
            <td>{{formatDate(reservation.field_until[0].value)}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import router from '../router';
export default {
  name: 'reservations-create',
  data () {
    return {
      from:'',
      until:'',
      calculateFrom: '',
      calculateUntil: '',
      dateDifference:0,
      datepickerF:'',
      datepickerU:'',
      vehicle:'',
      price: 0,
      totalPrice: 0,
      reservations: '',
      vehicleImage: '',
      vehicleName: '',
    }
  },
  created(){
    axios
      .get('http://localhost/api/couch/' + this.$route.params.vehicleID)
      .then(({data: response}) => {
        this.vehicle = response;
        this.price = this.vehicle[0].field_price[0].value;
        this.vehicleImage = this.vehicle[0].field_image[0].url
        this.vehicleName = this. vehicle[0].name[0].value
      })
      .catch(error => {
        console.info(error.message)
      })
    
    axios
      .get('http://localhost/api/reservations/vehicle/' + this.$route.params.vehicleID)
      .then(({data: response}) =>{
        this.reservations = response;
      })
      .catch(error =>{
        console.info(error.message)
      })
  },
  mounted: function () {
    this.$nextTick(function () {
      var datapickerFrom = document.querySelector('.datepicker-from');
      var datapickerUntil = document.querySelector('.datepicker-until');
      var instance10 = new M.Datepicker(datapickerFrom, {
        format: 'yyyy-mm-dd', 
        minDate: new Date(), 
        onSelect: function(selectDate){
          instance11.options.minDate = selectDate;
        }
      });
      this.from = instance10;
      var instance11 = new M.Datepicker(datapickerUntil,  {
        format: 'yyyy-mm-dd', 
        maxDate: 0,
        onSelect: function(selectDate){
          instance10.options.maxDate = selectDate;
        }
      });
      this.until = instance11;
    })
  },
  methods: {
    refreshFrom: function(){
      this.calculateFrom = this.$refs.from.value;
      console.log(this.calculateFrom);
      this.calculateTimeDifference();

    },

    refreshUntil: function(){
      this.calculateUntil = this.$refs.until.value;
      console.log(this.calculateUntil);
      this.calculateTimeDifference();
    },

    calculateTimeDifference: function(){
      if(this.calculateFrom){
        var date1 = new Date(this.calculateFrom);
        if(this.calculateUntil){
          var date2 = new Date(this.calculateUntil);
          var timeDiff = Math.abs(date2.getTime() - date1.getTime());
          var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
          this.dateDifference = diffDays + 1;
          this.totalPrice = this.dateDifference * this.price
          console.log(this.dateDifference);
        }
      }
    },
    formatDate(date) {
      var data = new Date(date);
      var day = data.getDate();
      var month = data.getMonth() + 1;
      var year = data.getFullYear();

      return year + '-' + month + '-' + day; 
    },

    addReservation: function(event){
      event.preventDefault();
      var uid = localStorage.getItem('uid')
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


      var newReservation =     {
        "field_couch": [
            {
                "target_id": this.$route.params.vehicleID,
                "target_type": "couch",
            }
        ],
        "field_from": [
            {
                "value": this.from.date
            }
        ],
        "field_price": [
            {
                "value": this.totalPrice
            }
        ],
        "field_until": [
            {
                "value": this.until.date
            }
        ],
        "field_imgvehicle": [
            {
                "value": this.vehicle[0].field_image[0].url
            }
        ],
        "field_namevehicle": [
            {
                "value": this.vehicle[0].name[0].value              
            }
        ]
    }

      axios
        .post('http://localhost/entity/reservation', newReservation, config)
        .then((response)=>{
          router.push('/my-reservations');  
        })
        .catch((error) => {
          console.log(error);
        })


    }
  }
}
</script>
 