import Vue from 'vue'
import Router from 'vue-router'
import CheckoutPage from '../components/CheckoutPage'
import AdminPage from '../components/AdminPage'
import LoginPage from '../components/LoginPage'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/checkout',
      name: 'Checkout',
      component: CheckoutPage
    },
    {
      path: '/admin',
      name: 'Admin',
      component: AdminPage
    },
    {
      path: '/login',
      name: 'Login',
      component: LoginPage
    }
  ]
})
