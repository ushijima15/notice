<template>
  <section class="container">
    <!-- v-if="own.is_admin" -->
    <div class="container">
      <div class="card text-center">
        <div class="card-body">
          <back-button />
          <h3 class="title-margin mt-3 mb-4">CSV取込</h3>
          <div class="d-flex justify-content-center mt-0">
            <div class="col-9 text-center">
              <div class="custom-control custom-checkbox">
                <input id="customCheck1" v-model="checked" type="checkbox" class="custom-control-input" />
                <label class="custom-control-label" for="customCheck1">ヘッダーあり</label>
              </div>
            </div>
          </div>
          <div class="d-flex align-items-center mt-4">
            <div class="col-4 text-right">受注データ</div>
            <div class="col-5">
              <csv-importer :file_name.sync="file_name" :is_header="checked" @file-change="orders = $event" />
            </div>
          </div>
          <div class="d-flex justify-content-center mt-5 mb-4">
            <div class="col-4">
              <button type="button" class="btn btn-block btn-primary" @click="onImport">データを取り込む</button>
            </div>
          </div>
        </div>
        <loading :active.sync="isLoading"></loading>
      </div>
    </div>
    <!-- <div key="non" v-else>
            <unauthorized/>
        </div> -->
  </section>
</template>

<script>
// import CsvImporter from '../src/vue-mg-csv-importer'
// import 'bootstrap/dist/css/bootstrap.min.css'
export default {
  filters: {
    convertTime(val) {
      // val は 秒
      if (!val) return '00:00:00'
      const hour = Math.floor(val / (60 * 60))
      const minute = Math.floor((val - hour * 60 * 60) / 60)
      const second = (val % 60) % 60
      return (
        (hour > 99 ? hour : ('00' + hour).slice(-2)) + ':' + ('00' + minute).slice(-2) + ':' + ('00' + second).slice(-2)
      )
    },
    addComma: function(val) {
      if (val) {
        return parseInt(val).toLocaleString()
      } else {
        return val
      }
    },
  },
  props: [
    //
  ],
  data() {
    return {
      file_name: '',
      checked: true,
      order_products: [],

      invalid: false,
      isLoading: false,
    }
  },
  computed: {
    own: function() {
      return this.$store.state.user
    },
  },
  watch: {
    //
  },
  mounted() {
    this.getInit()
  },
  methods: {
    async onImport() {
      this.invalid = false
      this.errorMessage = ''
      if (!this.file_name) {
        alert('受注データを指定してください。')
        return
      }
      this.isLoading = true
      try {
        if (this.file_name) {
          const { data } = await axios.post('/api/productcost/import', {
            orders: this.orders,
          })
        }
        alert('CSVを取り込みました。')
      } catch (error) {
        console.log(error)
        alert('CSVの取り込みに失敗しました。')
      } finally {
        this.isLoading = false
      }
    },
    isNumber(numVal) {
      // チェック条件パターン
      const pattern = /^[-]?([1-9]\d*|0)(\.\d+)?$/
      // 数値チェック
      return pattern.test(numVal)
    },
    ordersExponentialConv() {
      this.orders.forEach(element => {
        // 指数表記かのチェック
        if (!this.isNumber(element.col2)) {
          // 指数表記 -> 整数表記
          element.col2 = parseFloat(element.col2)
        }
      })
    },
    getInit() {
      this.isLoading = true
      const api = axios.create()
      axios.all([api.get('/api/productcost/csv_time')]).then(
        axios.spread((res1, res2) => {
          this.csv_time = res1.data.finishCSVtime
          this.isLoading = false
        }),
      )
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
</style>
