import Vue from 'vue'
import Router from 'vue-router'
import vehicleList from '@/components/Vehicle-List'
import vehicleDetail from '@/components/Vehicle-Detail'
import vehicleCreate from '@/components/Vehicle-Create'
import login from '@/components/Login'
import register from '@/components/Register'
import profile from '@/components/Profile'
import myVehicles from '@/components/My-Vehicles'
import myReservations from '@/components/My-Reservations'
import reservationCreate from '@/components/Reservation-Create'
import reservationEdit from '@/components/Reservation-Edit'

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
    },
    {
      path: '/profile',
      name: 'profile',
      component: profile
    },
    {
      path: '/my-vehicles',
      name: 'my-vehicles',
      component: myVehicles
    },
    {
      path: '/reserve/:vehicleID',
      name: 'reservation-create',
      component: reservationCreate
    },
    {
      path: '/my-reservations',
      name: 'my-reservations',
      component: myReservations
    },
    {
      path: '/reservation/:reservationID',
      name: 'reservation-edit',
      component: reservationEdit
    }
  ]
})
