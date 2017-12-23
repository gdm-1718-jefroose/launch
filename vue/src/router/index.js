import Vue from 'vue'
import Router from 'vue-router'
import vehicleList from '@/components/Vehicle-List'
import vehicleDetail from '@/components/Vehicle-Detail'
import vehicleCreate from '@/components/Vehicle-Create'
import login from '@/components/Login'
import register from '@/components/Register'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'vehicle-list',
      component: vehicleList
    },
    {
      path: '/vehicle/:vehicleID',
      name: 'vehicle-detail',
      component: vehicleDetail
    },
    {
      path:'/create',
      name: 'vehicle-create',
      component: vehicleCreate
    },
    {
      path: '/login',
      name: 'login',
      component: login
    },
    {
      path: '/register',
      name: 'register',
      component: register
    }
  ]
})
