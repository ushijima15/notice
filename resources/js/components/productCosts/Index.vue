<template>
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-wrap justify-content-start mb-1">
          <div class="mr-auto mb-3">
            <span class="span-header d-none d-sm-block">作業日報一覧</span>
            <span class="span-header d-block d-sm-none">作業日報<br />一覧</span>
          </div>
          <div class="align-self-center mr-3">
            <button type="button" class="btn btn-info btn-edit" @click="downloadCSV">
              <i class="fa fa-download" aria-hidden="true"></i>CSV
            </button>
          </div>
          <div class="align-self-center">
            <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
          </div>
        </div>
        <div class="d-flex flex-wrap mb-1">
          <div class="d-flex mb-2">
            <div class="d-flex mr-3 mb-1">
              <div class="align-self-center mr-2">作業日</div>
              <div class="align-self-center">
                <date-picker-from-to :from_dt.sync="started_from" :to_dt.sync="started_to" />
              </div>
            </div>
          </div>
          <div class="d-flex mb-1 mr-3">
            <div class="align-self-center mr-2">ラインNo.</div>
            <div class="">
              <select v-model="selected_line_no" class="form-control">
                <option value=""></option>
                <option v-for="(line_number, index) in line_numbers" :key="index" :value="line_number">{{
                  line_number
                }}</option>
              </select>
            </div>
          </div>
          <div class="mb-1">
            <button type="button" class="btn btn-primary" @click="onSearch">検索</button>
          </div>
        </div>
      </div>
      <table key="product_costs" class="table-custom mb-3">
        <thead>
          <tr>
            <!-- todo -->
            <th class="text-center bg-primary text-white"></th>
            <th class="text-center bg-primary text-white">作業日</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="product_cost in product_costs"
            :key="product_cost.id"
            class="bg-white clickable"
            :class="classObject(product_cost)"
            @click="onResume(product_cost)"
          >
            <td data-label="" class="text-sm-center">
              <button v-if="product_cost.is_add" class="btn btn-success text-white">
                追加
              </button>
            </td>
            <!-- todo -->
            <td data-label="作成日" class="text-sm-center">{{ product_cost.worked_on }}</td>
          </tr>
        </tbody>
      </table>
      <pagination
        :page="currentPage"
        :items-per-page="itemsPerPage"
        :max-visible-pages="maxVisiblePages"
        :total-items="totalItems"
        @pageChange="pageChange"
      />
      <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
    </div>
  </div>
</template>

<script>
import Moment from 'moment'
export default {
  filters: {
    convertTime(val) {
      // val は 秒
      if (!val) return '00:00'
      const hour = Math.floor(val / (60 * 60))
      const minute = Math.floor((val - hour * 60 * 60) / 60)
      // 秒単位まで表示
      return (hour > 99 ? hour : ('00' + hour).slice(-2)) + ':' + ('00' + minute).slice(-2)
    },
  },
  props: [
    //
  ],
  data() {
    return {
      product_costs: [],
      employees: [],
      line_numbers: [],
      started_from: '',
      started_to: '',
      selected_line_no: '',
      type: 1,

      currentPage: 0,
      itemsPerPage: 20,
      maxVisiblePages: 4,
      totalItems: 0,
      offset: 0,

      isLoading: false,
      fullPage: false,
      filterWarehouse: [],

      sort: {
        key: 'id', // ソートキー
        isAsc: true, // 昇順ならtrue,降順ならfalse
      },
      barcode_url: '',
    }
  },
  computed: {
    classObject() {
      return product_cost => {
        return {
          todo: product_cost.display_state === '未完了',
          doing: product_cost.display_state === '作業中',
          done: product_cost.display_state === '完了',
        }
      }
    },
  },
  watch: {
    //
  },
  mounted: function() {
    this.getInit()
  },
  methods: {
    async getInit() {
      this.isLoading = true
      const api = axios.create()
      const [res1] = await axios.all([api.get('/api/employee/selector')])
      this.employees = res1.data
      this.isLoading = false
      if (this.$store.state.barcode) {
        this.started_from = ''
        this.started_to = ''
        this.selected_line_no = ''
        this.getItems()
      }
    },
    async getItems() {
      this.isLoading = true
      const { data } = await axios.get('/api/productcost', {
        params: {
          // todo

          offset: this.offset,
          limit: this.itemsPerPage,
          sort: this.sort,
        },
      })
      this.product_costs = data.product_costs
      this.line_numbers = data.line_numbers
      this.totalItems = data.total_items
      localStorage.setItem('started_from', this.started_from ? this.started_from : '')

      this.isLoading = false
    },
    onResume(product_cost) {
      this.$router.push({ name: 'product_cost.resume', params: { productCostId: product_cost.id } })
    },
    onBack() {
      this.$router.push({ name: 'home' })
    },
    onSearch() {
      this.$store.state.barcode = ''
      this.offset = 0
      this.currentPage = 0
      this.getItems()
    },
    pageChange(page, start, end) {
      if (end === 1) return
      this.currentPage = page
      this.offset = start
      this.getItems()
    },
    async sortBy(key) {
      this.sort.isAsc = this.sort.key === key ? !this.sort.isAsc : true
      this.sort.key = key
      await this.getItems()
    },
    sortedClass(key) {
      return this.sort.key === key ? `sorted ${this.sort.isAsc ? 'asc' : 'desc'}` : ''
    },
    downloadCSV: function() {
      axios({
        method: 'post',
        // todo
        // url: ,
        data: {
          from: this.started_from,
          to: this.started_to,
        },
      }).then(function(res1) {
        const blob = new Blob(['\ufeff' + res1.data], { type: 'text/csv' })
        const link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = '作業日報.csv'
        link.click()
      })
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
.clickable:hover {
  background-color: #fff8e1 !important;
  color: #000000 !important;
}
.clickable {
  cursor: pointer;
}

.table-custom {
  width: 100%;
  min-width: 1000px;
  border-collapse: separate;
  border-spacing: 0;
  border: 1px solid #ccc;
  border-radius: 0.35rem;
  padding: 0;
  margin: 0;
}
.table-custom tr {
  border: 1px solid #ddd;
  padding: 5px;
}
.table-custom th,
.table-custom td {
  padding: 10px;
  text-align: center;
  border-bottom: 1px solid #ccc;
}
.table-custom th {
  color: white;
  letter-spacing: 1px;
}

.table-custom tr:first-child th:first-child {
  border-radius: 0.35rem 0 0 0;
}
.table-custom tr:last-child td:first-child {
  border-radius: 0 0 0 0.35rem;
}
.table-custom tr:first-child th:last-child {
  border-radius: 0 0.35rem 0 0;
}

.table-custom tr:last-child td:last-child {
  border-radius: 0 0 0.35rem 0;
}

table tr:hover {
  background-color: #fff8e1 !important;
}
.doing {
  background-color: #b9f6ca !important;
}
.done {
  background-color: #bdbdbd !important;
}
.stop {
  background-color: #f67979 !important;
}
.finish {
  background-color: #bad3ff !important;
}
.temporary {
  background-color: #ffff66 !important;
}
.sort-clicable:hover {
  // background-color: darken($primary, 10%) !important;
  background-color: lighten($primary, 20%) !important;
}
.sort-clicable {
  cursor: pointer;
  position: relative;
}
</style>
