import Vue from 'vue'
import Router from 'vue-router'
import Hello from '@/components/Hello'
import Login from '@/main/Login'
import Dashboard from '@/main/Dashboard'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Hello',
      component: Hello
    },
    {
      path: '/login',
      name: '/login',
      component: Login
    },
    {
      path: '/main',
      name: '/main',
      component: Dashboard
    }
  ]
})
