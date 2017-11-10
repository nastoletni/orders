import Vue from 'vue'
import Router from 'vue-router'
import CheckoutPage from '../components/CheckoutPage';
Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/checkout',
      name: 'Checkout',
      component: CheckoutPage
    }
  ]
})
