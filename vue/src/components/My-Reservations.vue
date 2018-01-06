<template> 
  <div class="row">
    <div class="col s12">
      <h5> MY RESERVATIONS </h5>
        <div class="col s12">
          <ul class="collection">
            <li class="collection-item avatar" v-for="reservation in reservations">
              <img class="circle" src="https://secure.img1-fg.wfcdn.com/im/69056323/resize-h299-p1-w299%5Ecompr-r85/3321/33218498/Patricia+Loveseat.jpg" alt="Couch">
              <span class="title">{{reservation.field_couch[0].target_id}}</span>
              <p><strong>From: </strong>{{reservation.field_from[0].value}}</p>
              <p><strong>Until: </strong>{{reservation.field_until[0].value}}</p>
              <div class="secondary-content">
                <a><i class="material-icons right">edit</i></a>
                <a><i class="material-icons right">money_off</i></a>
              </div>
            </li>
          </ul>
        </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'my-reservations',
  data () {
    return {
      reservations: '',
      couchIds:'',
      vehicles: ''
    }
  },
  created() {
    var uid = localStorage.getItem('uid');
    axios
      .get('http://localhost/api/reservations/' + uid)
      .then(({data: response})=> {
        this.reservations = response;
        axios
          .get('http://localhost/api/couches')
          .then(({data: response}) => {
            this.vehicles = response;
          })
          
      })
      .catch(error => {
        console.info(error.message)
      })
  }

}
</script>
 