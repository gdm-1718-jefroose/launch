<template> 
  <div class="row">
    <form class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <input id="name" type="text" class="validate">
          <label for="name">Name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="longitude" type="text" class="validate">
          <label for="longitude">longitude</label>
        </div>
      </div>
      <div class="input-field col s12">
        <select>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
        </select>
        <label>Seats</label>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="latitude" type="text" class="validate">
          <label for="latitude">latitude</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="price" type="text" class="validate">
          <label for="price">price</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="battery" type="text" class="validate">
          <label for="battery">battery</label>
        </div>
      </div>
    </form>
  </div>    
</template>

<script>
export default {
  name: 'vehicle-create',
  data () {
    return {
    }
  },
  created() {
    console.log('test');
  }
}
</script>
 