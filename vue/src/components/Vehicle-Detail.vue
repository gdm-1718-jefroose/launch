<template> 
  <div class="row">
    <div v-show="loading" class="progress">
      <div class="indeterminate"></div>
    </div>
    <div class="col s12 m12" v-for="vehicleItem in vehicle">
      <div class="card">
        <div class="card-image">
          <img :src="vehicleItem.field_image[0].url" alt="couch">
          <span class="card-title blue lighten-1">{{ vehicleItem.name[0].value }}</span>
        </div>
        <div class="card-content">
          <p><strong>Seats: </strong>{{ vehicleItem.field_seats[0].value }}</p>
          <p><strong>Licence: </strong>{{ vehicleItem.field_license[0].value }}</p>
          <p><strong>Battery: </strong>{{ vehicleItem.field_battery[0].value }}%</p>
        </div>
      </div>
      <router-link :to="{ name: 'reservation-create', params: { vehicleID: vehicleItem.id[0].value }}" class="col s12 btn-large waves-effect waves-light blue lighten-1">Make a reservation</router-link>
    </div>

    <div class="col s12">
      <h5 class="center"> REVIEWS </h5>
      <blockquote>
        See what other people did experience with this couch.
      </blockquote>
      <ul class="collapsible">
        <li v-for="review in reviews">
          <div class="collapsible-header">
            {{review.name[0].value}}
            <span class="badge">
              {{review.field_rating[0].value}}
              <i class="material-icons right">star</i>
            </span>
          </div>
          <div class="collapsible-body"><span>{{review.field_body[0].value}}</span></div>
        </li>
      </ul>

      <h5 class="center"> ADD REVIEW </h5>
      <blockquote>
        Tell other people what you've experienced.
      </blockquote>
      <form class="col s12 card-panel" v-on:submit="addReview">
        <div class="row">
          <div class="input-field col s12">
            <input id="title" type="text" class="validate" v-model="title" required>
            <label for="title">Title</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="body" class="materialize-textarea" v-model="body" required></textarea>
            <label for="body">Review</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12 ">
            <select class="select-rating"  v-model="rating" required>
              <option value=1>1</option>
              <option value=2>2</option>
              <option value=3>3</option>
              <option value=4>4</option>
              <option value=5>5</option>
            </select>
            <label>Rating</label>
          </div>
        </div>
        <button class="btn waves-effect waves-light blue lighten-1 col s12" type="submit" name="action">Add
          <i class="material-icons right">send</i>
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
import router from '../router';
export default {
  name: 'vehicle-detail',
  data () {
    return {
      vehicle: '',
      reviews: '',
      loading: false,
      couchID: 0,
      title: '',
      body: '',
      rating: 0
    }
  },
  updated: function () {
    this.$nextTick(function () {
      var collapsible = document.querySelector('.collapsible');
      var instance5 = new M.Collapsible(collapsible);
    })
  },
  mounted: function () {
    this.$nextTick(function () {
      var rating = document.querySelector('.select-rating');
      var instance7 = new M.Select(rating);
    })
  },
  created() {
      this.loading = true;
      this.couchID = this.$route.params.vehicleID;
      axios
        .get('http://localhost/api/couch/' + this.$route.params.vehicleID)
        .then(({data: response}) => {
          this.loading = false;
          this.vehicle = response;
        })
        .catch(error => {
          console.info(error.message)
        })

      axios
        .get('http://localhost/api/review/' + this.$route.params.vehicleID)
        .then(({data: response}) => {
          this.reviews = response;
        })
        .catch(error => {
          console.info(error.message)
        })

  },
  methods: {
    addReview: function(event){
      event.preventDefault();
      
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


      var newReview = {
                "name": [
                    {
                        "value": this.title
                    }
                ],
                "status": [
                    {
                        "value": true
                    }
                ],
                "field_body": [
                    {
                        "value": this.body
                    }
                ],
                "field_couches": [
                    {
                        "target_id": this.couchID,
                        "target_type": "couch"
                    }
                ],
                "field_rating": [
                    {
                        "value": this.rating
                    }
                ]
            }

      axios
        .post('http://localhost/entity/review', newReview, config)
        .then((response)=>{
          console.log('/vehicle/' + this.couchID);  
          router.go('/vehicle/' + this.couchID);  
        })
        .catch((error) => {
          console.log(error);
        })


    }


  },
}
</script>
 