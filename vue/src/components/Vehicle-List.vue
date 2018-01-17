<template>
  <div class="row">
    <div class="col s12">
      <ul class="tabs">
        <li class="tab col s6"><a class="active" href="#overview">Overview</a></li>
        <li class="tab col s6"><a href="#map">Map</a></li>
      </ul>
    </div>
    <div v-show="loading" class="progress">
      <div class="indeterminate"></div>
    </div>
    <div class="col s12" id="overview">
      <!--<div class="nav-wrapper">
        <form>
          <div class="input-field">
            <input id="search" type="search"  v-model="liveFilter" required>
            <label class="label-icon" for="search"><i class="material-icons">search</i></label>
            <i class="material-icons">close</i>
          </div>
        </form>
      </div>-->
      <ul class="collection">
        <li class="collection-item avatar" v-for="vehicle in vehicles">
          <img class="circle" :src="vehicle.field_image[0].url"  alt="Couch">
          <span class="title">{{ vehicle.name[0].value }}</span>
          <p><strong>Seats:</strong> {{ vehicle.field_seats[0].value }}</p>
          <p><strong>Licence:</strong> {{ vehicle.field_license[0].value }}</p>
          <router-link :to="{ name: 'vehicle-detail', params: { vehicleID: vehicle.id[0].value }}" class="secondary-content"><i class="material-icons">forward</i></router-link>
        </li>
      </ul>
    </div>
    <div class="col s12" id="map">
      <gmap-map
        :style="{display: 'inline-block', width: '100%',height: '80vh',}"
        :center="{lat:currentLocation.lat, lng:currentLocation.lng}"
        :zoom="zoom"
        :resize-bus="customBus">
      <gmap-info-window 
        :options="infoOptions" 
        :position="infoWindowPos" 
        :opened="infoWinOpen" 
        @closeclick="infoWinOpen=false">
        {{infoContent}}
      </gmap-info-window>
        <gmap-marker
          :key="index"
          v-for="(m, index) in markers"
          :position="m.position"
          :clickable="true"
          @click="toggleInfoWindow(m,index)"
        ></gmap-marker>
      </gmap-map>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Vue from 'vue'
export default {
  name: 'vehicle-list',
  data () {
    return {
      vehicles: '',
      loading: false,
      zoom: 12,
      customBus: new Vue(),
      infoContent: '',
      infoWindowPos: {
        lat: 0,
        lng: 0
      },
      infoOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      infoWinOpen: false,
      currentMidx: null,
      currentLocation: {
        lat: 0,
        lng: 0
      },
      markers:''
    }
  },
  updated: function () {
    this.$nextTick(function () {
      this.customBus.$emit('resize');
    })
  },
  mounted: function () {
    this.$nextTick(function () {
      var tabs = document.querySelector('.tabs');
      if (tabs){
        var instance4 = new M.Tabs(tabs);
      }
    })
  },
  created() {
    this.loading = true;
    axios
      .get('http://localhost/api/couches')
      .then(({data: response}) => {
        this.loading = false;
        this.vehicles = response;
        
        var data = []
        for (var i = 0; i < this.vehicles.length; i++) { 
          var tempData = {
            'position':{
              "lat": this.vehicles[i].field_latitude[0].value,
              "lng": this.vehicles[i].field_longitude[0].value
            },
            'info': this.vehicles[i].name[0].value
          }
          data.push(tempData);
        }
        this.markers = data
      })
      .catch(error => {
        console.info(error.message)
      })

    navigator.geolocation.getCurrentPosition((position) => {
      this.currentLocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude,
      };
    });

  },
  methods: {
    toggleInfoWindow: function(marker, idx) {
      this.infoWindowPos = marker.position;
      this.infoContent = marker.info;
      //check if its the same marker that was selected if yes toggle
      if (this.currentMidx == idx) {
        this.infoWinOpen = !this.infoWinOpen;
      }
      //if different marker set infowindow to open and reset current marker index
      else {
        this.infoWinOpen = true;
        this.currentMidx = idx;
      }
    }
  }
}
</script>
