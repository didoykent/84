import Vue from 'vue'

import VueRouter from 'vue-router'

import axios from 'axios'

import store from './store'



Vue.use(VueRouter)


const notLogged = (to, from, next) => {
  if (!store.getters.isLogged) {
    next()
    return
  }
  next('/student-login')
}



const isLogged = (to, from, next) => {
  if (store.getters.isLogged) {
    next()
    return
  }
  next('/chatglobal')
}



const router = new VueRouter({



  routes: [


    {path: '/student-login', component:require('./components/Auth/StudentLogin.vue'),  beforeEnter: notLogged},
    {path: '/student-logout', component:require('./components/Auth/StudentLogout.vue'), beforeEnter: isLogged},

    {path: '/chatglobal', component:require('./components/Chat/chatglobal.vue'), beforeEnter: isLogged},
    {path: '/chatglobal/:chatroute', component:require('./components/Chat/chatglobal.vue'), beforeEnter: isLogged}



  ]
});


export default router
