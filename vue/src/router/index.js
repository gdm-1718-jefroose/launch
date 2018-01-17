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
      component: vehicleList,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      }  
    },
    {
      path: '*',
      redirect: '/login'
    },
    {
      path: '/vehicle/:vehicleID',
      name: 'vehicle-detail',
      component: vehicleDetail,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    },
    {
      path:'/create',
      name: 'vehicle-create',
      component: vehicleCreate,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
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
      component: profile,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    },
    {
      path: '/my-vehicles',
      name: 'my-vehicles',
      component: myVehicles,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    },
    {
      path: '/reserve/:vehicleID',
      name: 'reservation-create',
      component: reservationCreate,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    },
    {
      path: '/my-reservations',
      name: 'my-reservations',
      component: myReservations,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    },
    {
      path: '/reservation/:reservationID',
      name: 'reservation-edit',
      component: reservationEdit,
      beforeEnter: (to, from, next) => {
        if (localStorage.getItem('auth') == null) {
          next('/login')
        } else {
          next()
        }
      } 
    }
  ]
})
