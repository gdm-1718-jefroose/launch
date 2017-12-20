<template>
  <div id="app">
    <nav>
      <div class="nav-wrapper">
        <router-link to="/" class="brand-logo">Launch</router-link>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><router-link to="/login">Login</router-link></li>
        </ul>
        <ul class="sidenav" id="mobile-demo">
          <li><router-link to="/login">Login</router-link></li>
        </ul>
      </div>
    </nav>

    <main>
      <router-view></router-view>
    </main>
            
  </div>
</template>


<script>
export default {
  name: 'app'
}
</script>

<style lang="scss">
  @import 'assets/css/app.css';
</style>