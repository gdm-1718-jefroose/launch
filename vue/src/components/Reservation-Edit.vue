<template> 
  <div class="row">
    <div class="col s12">
      <h5 class="center"> EDIT RESERVATION </h5>
      <blockquote>
        Edit your reservation
      </blockquote>
        <form class="card-panel" v-on:submit="addReservation">
          <div class="row">
            <div class="input-field col s12">
              <input id="from" type="text" class="datepicker-from" ref="from" v-bind:placeholder="formatDate(this.oldFrom)" v-on:change="refreshFrom" required>
              <label class="active" for="from">From</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input id="until" type="text" class="datepicker-until" ref="until" v-bind:placeholder="formatDate(this.oldUntil)" v-on:change="refreshUntil" required>
              <label class="active" for="until">Until</label>
            </div>
          </div>
          <div class="row">
            <div class="col s6">
              <p>Days: <span>{{dateDifference}}</span></p>
            </div>
            <div class="col s6">
              <p>Price: €
                <span v-show="changed">{{totalPrice}}</span>
                <span v-show="!changed">{{oldPrice}}</span>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col s12">
              <button class="btn waves-effect waves-light" type="submit" name="action">Edit reservation
                <i class="material-icons right">send</i>
              </button>
            </div>
            <br/>
            <br/>
            <div class="col s12">
              <router-link class="btn waves-effect waves-light red" to="/my-reservations">Cancel
              </router-link>
            </div>
          </div>
        </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import router from '../router';
import Vue from 'vue'
export default {
  name: 'reservations-edit',
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
      vehicleID:'',
      reservation:'',
      oldFrom:'',
      oldUntil:'',
      oldPrice: '',
      price: 0,
      totalPrice: 0,
      changed: false
    }
  },
  created(){
    this.getData();
  },
  mounted: function () {
    this.$nextTick(function () {
    })
  },
  methods: {
    getData: function(){
      axios
        .get('http://localhost/api/reservations/' + this.$route.params.reservationID)
        .then(({data: reservationArray})=> {
          this.reservation = reservationArray;
          console.log(reservationArray[0].field_from[0].value)
          this.oldFrom = this.reservation[0].field_from[0].value;
          this.oldUntil =  this.reservation[0].field_until[0].value;
          this.oldPrice = this.reservation[0].field_price[0].value;
          this.initCalendar();
          this.vehicleID = this.reservation[0].field_couch[0].target_id
          axios
            .get('http://localhost/api/couch/' + this.vehicleID)
            .then(({data: vehicleArray}) => {
              this.vehicle = vehicleArray
              this.price = this.vehicle[0].field_price[0].value
            })
            .catch(error => {
              console.info(error.message)
            })
        })
        .catch(error => {
          console.info(error.message)
        })
        
    },
    initCalendar: function(){
      var datapickerFrom = document.querySelector('.datepicker-from');
      var instance12 = new M.Datepicker(datapickerFrom, {
        format: 'yyyy-mm-dd', 
        minDate: new Date(),
        defaultDate: Date(this.reservation[0].field_from[0].value),
        setDefaultDate: true,
        onSelect: function(selectDate){
          instance13.options.minDate = selectDate;
        }
      });
      this.from = instance12;

      var datapickerUntil = document.querySelector('.datepicker-until');
      var instance13 = new M.Datepicker(datapickerUntil,  {
        format: 'yyyy-mm-dd', 
        maxDate: 0,
        defaultDate: Date(this.reservation[0].field_until[0].value),
        setDefaultDate: true,
        onSelect: function(selectDate){
          instance12.options.maxDate = selectDate;
        }
      });
      this.until = instance13;
    },
    refreshFrom: function(){
      this.calculateFrom = this.$refs.from.value;
      this.changed = true
      console.log(this.calculateFrom);
      this.calculateTimeDifference();

    },

    refreshUntil: function(){
      this.calculateUntil = this.$refs.until.value;
      this.changed = true
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


      var editReservation =     {
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
        "field_paid": [
            {
                "value": false
            }
        ]
    }

      axios
        .patch('http://localhost/launch/reservation/' + this.$route.params.reservationID, editReservation, config)
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
 