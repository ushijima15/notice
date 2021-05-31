/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import VueRouter from 'vue-router'
import Vuex from 'vuex'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.min.css'

// https://www.npmjs.com/package/vue-full-calendar
import FullCalendar from 'vue-full-calendar'
import 'fullcalendar/dist/fullcalendar.css'
import 'fullcalendar-scheduler/dist/scheduler.min.js'
import 'fullcalendar-scheduler/dist/scheduler.min.css'
// https://github.com/robinvdvleuten/vuex-persistedstate
import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

import createPersistedState from 'vuex-persistedstate'
import DatePickerStandard from 'vue-mg-date-picker-standard'
import DatePickerFromTo from 'vue-mg-date-picker-from-to'
import ModalKeypad from 'vue-mg-modal-keypad'
import ImageFileUploader from 'vue-mg-image-file-uploader'
import TimePickerSelector from 'vue-mg-time-picker-selector'
import MgPaginate from 'vue-mg-paginate'
import ToggleSelector from 'vue-mg-toggle-selector'
import ModalDialog from 'vue-mg-modal-dialog'
// import DateTimeSelector from "vue-mg-date-time-selector";
// Vue.component("DateTimeSelector", DateTimeSelector);
import CsvImporter from 'vue-mg-csv-importer'
import VueInputCalculator from 'vue-input-calculator'
require('./bootstrap')

window.Vue = require('vue')
Vue.use(VueRouter)
Vue.use(Vuex)
// Bootstrap-Vue
window.BootstrapVue = require('bootstrap-vue')
Vue.use(BootstrapVue)
Vue.component('Loading', Loading)
Vue.use(FullCalendar)
Vue.component('Multiselect', Multiselect)
Vue.component('DatePickerStandard', DatePickerStandard)
Vue.component('DatePickerFromTo', DatePickerFromTo)
Vue.component('ModalKeypad', ModalKeypad)
Vue.component('ImageFileUploader', ImageFileUploader)
Vue.component('TimePickerSelector', TimePickerSelector)
Vue.component('MgPaginate', MgPaginate)
Vue.component('ToggleSelector', ToggleSelector)
Vue.component('ModalDialog', ModalDialog)
Vue.component('CsvImporter', CsvImporter)
Vue.component('VueInputCalculator', VueInputCalculator)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('MainComponent', require('./components/MainComponent.vue').default)
Vue.component('BackButton', require('./components/commons/buttons/BackButton.vue').default)
Vue.component('Pagination', require('./components/commons/Pagination.vue').default)
Vue.component('SelectName', require('./components/commons/SelectName.vue').default)
Vue.component('SearchComponent', require('./components/commons/ModalSearchComponent.vue').default)

const router = new VueRouter({
  mode: 'history',
  routes: [
    // ホーム
    { name: 'home', path: '/', component: require('./components/HomeComponent.vue').default },

    // 作業時間
    { name: 'product_cost', path: '/product_cost', component: require('./components/productCosts/Index.vue').default },
    {
      name: 'product_cost.create',
      path: '/product_cost/create/:product_plan_id',
      component: require('./components/productCosts/Create.vue').default,
      props: true,
    },
    {
      name: 'product_cost.resume',
      path: '/product_cost/resume/:productCostId',
      component: require('./components/productCosts/Create.vue').default,
      props: true,
    },
    // 設定
    { name: 'setting', path: '/setting', component: require('./components/settings/Index.vue').default },

    // 従業員
    { name: 'employee', path: '/employee', component: require('./components/employees/Index.vue').default },
    {
      name: 'employee.create',
      path: '/employee/create',
      component: require('./components/employees/CreateUpdate.vue').default,
    },
    {
      name: 'employee.show',
      path: '/employee/show/:employeeId',
      component: require('./components/employees/CreateUpdate.vue').default,
      props: true,
    },

    // csv取り込み
    { name: 'csv', path: '/csv', component: require('./components/csv/Index.vue').default },

    // not found
    { path: '*', component: require('./components/commons/NotFoundComponent.vue').default },
  ],
})

const store = new Vuex.Store({
  state: {
    user: '',
    barcode: '',
    sort: {
      key: '', // ソートキー
      isAsc: false, // 昇順ならtrue,降順ならfalse
    },
  },
  mutations: {
    setUser(state, payload) {
      state.user = payload
    },
  },
  actions: {
    async getUser(context) {
      const { data } = await axios.get('/api/user/info')
      context.commit('setUser', data)
    },
  },
  plugins: [createPersistedState()],
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('addComma', function(value) {
  if (value) {
    return value.toLocaleString()
  } else {
    return ''
  }
})

const app = new Vue({
  el: '#app',
  store,
  router,
})
