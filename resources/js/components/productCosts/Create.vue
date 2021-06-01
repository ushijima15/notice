<template>
  <div class="container">
    <div class="d-flex justify-content-start mb-2">
      <div class="mr-auto">
        <span class="span-header">作業日報</span>
      </div>
      <div class="align-self-center">
        <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
      </div>
    </div>
    <div class="row mt-1 mb-2">
      <div class="form-group col mb-1">
        <label for="">作業日</label>
        <input type="text" readonly class="form-control-plaintext ml-3" :value="product_cost.worked_on" />
      </div>
      <!-- ラインNoを追加 -->
    </div>
    <div class="row mb-2">
      <div class="form-group col-sm">
        <label for="">作業員</label>
      </div>
    </div>
    <div class="row mb-3">
      <!-- 部品番号・C/T(min)・納入指示日を追加 -->
    </div>

    <div class="row d-flex">
      <div v-if="show" class="form-group col-sm mb-sm-4">
        <button
          type="button"
          class="btn btn-block btn-lg btn-super"
          :class="classStart"
          :disabled="start_disabled"
          @click="onStart"
        >
          作業開始
        </button>
      </div>
    </div>
    <div v-if="show" class="row">
      <div class="form-group col">
        <button
          type="button"
          class="btn btn-block btn-lg btn-super"
          :class="classFinish"
          :disabled="finish_disabled"
          @click="onFinish"
        >
          終了
        </button>
      </div>
    </div>
    <div class="d-flex justify-content-center">
      <!-- 製作数量と作業時間を追加する -->
    </div>
    <div class="d-flex justify-content-center mt-3 mb-4">
      <div v-if="own.is_admin">
        <button type="button" class="btn btn-outline-danger mr-5" @click="onDelete">この日報を削除する</button>
      </div>
      <div>
        <button
          type="button"
          class="btn btn-primary mr-5"
          :disabled="product_cost.is_finished === 1"
          @click="onAllFinish"
        >
          完了
        </button>
      </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
  </div>
</template>

<script>
export default {
  filters: {
    convertTime(val) {
      // val は 秒
      if (!val) return '00:00'
      const hour = Math.floor(val / (60 * 60))
      const minute = Math.floor((val - hour * 60 * 60) / 60)
      const second = (val % 60) % 60
      // 分単位まで表示
      return (hour > 99 ? hour : ('00' + hour).slice(-2)) + ':' + ('00' + minute).slice(-2)
      // return (hour > 99 ? hour : ('00' + hour).slice(-2)) +  ':' + ('00' + minute).slice(-2) + ':' + ('00' + second).slice(-2)
    },
    addComma: function(val) {
      if (val) {
        return parseInt(val).toLocaleString()
      } else {
        return val
      }
    },
  },
  props: ['productCostId'],
  data() {
    return {
      product_cost: {},
      employees: [],

      state: {
        is_start: false,
        is_finish: false,
      },
      default_state: {
        is_start: false,
        is_finish: false,
      },
      worked_time: '',

      product_time: '',
      isDisabled: false,
      is_new: false,

      isLoading: false,
      fullPage: true,
      show: true,
    }
  },
  computed: {
    own() {
      return this.$store.state.user
    },
    isAdmin() {
      return this.own.is_admin
    },
    isTimeEditor() {
      return this.own.is_time_editor
    },
    label_stop: function() {
      return this.state.is_stop ? '始業' : '終業'
    },
    classStart() {
      // todo
      return {
        'btn-success': this.is_new,
        'btn-secondary': !this.is_new,
      }
    },
    classFinish() {
      return {
        'btn-danger': !this.is_new,
        'btn-secondary': this.state.is_new,
      }
    },
    start_disabled() {
      if (this.state.is_new) return false
      return false
    },
    finish_disabled() {
      if (this.state.is_finish) return true
      return false
    },
    state_all() {
      return {
        state: this.state,
        product_time: this.product_time,
        setup_time: this.setup_time,
        product_break_time: this.product_break_time,
        setup_break_time: this.setup_break_time,
      }
    },
    default_state_all() {
      return {
        state: this.default_state,
        product_time: '',
        setup_time: '',
        product_break_time: '',
        setup_break_time: '',
      }
    },
  },
  watch: {},
  created() {
    this.getItems()
    setInterval(() => {
      if (!this.state.is_finish && (this.state.is_start || this.state.is_setupRestart)) this.product_cost.worked_time++
    }, 1000)
  },
  methods: {
    async getItems() {
      this.isLoading = true
      const api = axios.create()
      const [res1] = await axios.all([api.get('/api/employee/selector')])
      this.employees = res1.data

      const _this = this
      const { data } = await axios.get('/api/productcost/' + this.productCostId)
      this.product_cost = data
      if (data.state) {
        this.state = data.state.state
        this.product_time = data.state.product_time
        if (this.state.is_finish) {
          this.is_new = true
        } else {
          this.is_new = false
        }
      } else {
        this.state = this.default_state
        this.product_time = ''
        this.is_new = true
      }
      this.isLoading = false
    },
    async onStart() {
      // 作業開始
      if (this.product_cost.workers.length === 0) {
        alert('作業員を選択してください。')
        return
      }
      // 作業開始のみ押された場合
      const bk_state = JSON.parse(JSON.stringify(this.state))
      this.state.is_start = true
      this.state.is_setupping = false
      this.state.is_break = false
      this.state.is_setupBreak = false
      this.state.is_restart = false
      this.state.is_setupRestart = false
      this.state.is_finish = false
      this.is_new = false
      let product_cost_id = ''
      product_cost_id = this.productCostId

      const { data } = await axios
        .post('/api/productcost/start_product_time/' + this.productCostId, {
          product_cost: this.product_cost,
          state: this.state_all,
        })
        .catch(error => {
          if (error.response.status === 401) {
            alert('セッションの有効期限が切れました。再度ログインしてください。')
            location.href = '/login'
          } else if (error.response.status === 500) {
            alert(error.response.data.message)
          } else {
            alert('※通信に失敗しました。\nネットワーク状態を確認の上、もう一度登録してください。')
          }
          this.state = JSON.parse(JSON.stringify(bk_state))
          this.is_new = true
          throw new Error()
        })
      this.product_time = data.product_time
      this.product_cost.updated_at = data.product_cost.updated_at
    },
    async onFinish() {
      // 作業終了
      // todo
      // 従業員が選択されていなかった場合、アラートを表示させる

      const bk_state = JSON.parse(JSON.stringify(this.state))
      this.state.is_start = false
      this.state.is_setupping = false
      this.state.is_break = false
      this.state.is_setupBreak = false
      this.state.is_restart = false
      this.state.is_setupRestart = false
      this.state.is_finish = true
      this.is_new = true

      const { data } = await axios
        .post('/api/productcost/finish_product_time/' + this.product_time.id, {
          product_cost: this.product_cost,
          state: this.state_all,
          is_copy: this.is_copy,
        })
        .catch(error => {
          if (error.response.status === 401) {
            alert('セッションの有効期限が切れました。再度ログインしてください。')
            location.href = '/login'
          } else if (error.response.status === 500) {
            alert(error.response.data.message)
          } else {
            alert('※通信に失敗しました。\nネットワーク状態を確認の上、もう一度登録してください。')
          }
          this.state = JSON.parse(JSON.stringify(bk_state))
          this.is_new = false
          throw new Error()
        })
      this.product_time = data.product_time
      this.product_cost.updated_at = data.product_cost.updated_at
    },
    async onStore() {
      // 一時保存
      if (this.product_cost.workers.length === 0) {
        alert('作業員を選択してください。')
        return
      }
      try {
        this.isLoading = true
        const { data } = await axios
          .put('/api/productcost/' + this.productCostId, {
            product_cost: this.product_cost,
            state: this.state_all,
          })
          .catch(error => {
            if (error.response.status === 401) {
              alert('セッションの有効期限が切れました。再度ログインしてください。')
              location.href = '/login'
            } else if (error.response.status === 500) {
              alert(error.response.data.message)
            } else {
              alert('※通信に失敗しました。\nネットワーク状態を確認の上、もう一度登録してください。')
            }
            throw new Error()
          })
        alert('一時保存しました。')
        this.product_cost.updated_at = data.product_cost.updated_at
      } catch (e) {
        console.log(e)
      } finally {
        this.isLoading = false
      }
    },
    async onGroupWorking() {
      this.group_process_id = this.product_cost.process_id
      this.onCreate()
    },
    async onCreate() {
      try {
        this.isLoading = true
        const { data } = await axios.post('/api/productcost/continue', {
          product_cost: this.product_cost,
          // state: this.default_state_all
        })
      } catch (e) {
        console.log(e)
      } finally {
        this.isLoading = false
      }
    },
    async onAllFinish() {
      // 全工程終了
      if (!this.state.is_finish) {
        alert('作業を終了してください。')
        return
      }
      if (this.product_cost.workers.length === 0) {
        alert('作業員を選択してください。')
        return
      }
      if (!confirm('作業を完了します。よろしいですか？')) {
        return
      }
      try {
        const { data } = await axios
          .post('/api/productcost/all_finish/' + this.productCostId, {
            product_cost: this.product_cost,
          })
          .catch(error => {
            if (error.response.status === 401) {
              alert('セッションの有効期限が切れました。再度ログインしてください。')
              location.href = '/login'
            } else if (error.response.status === 500) {
              alert(error.response.data.message)
            } else {
              alert('※通信に失敗しました。\nネットワーク状態を確認の上、もう一度登録してください。')
            }
            throw new Error()
          })
        this.onBack()
      } catch (e) {
        console.log(e)
      } finally {
        //
      }
    },
    onEdit() {
      this.$router.push({ name: 'product_cost.edit', params: { productCostId: this.productCostId } })
    },
    onBack: function() {
      this.$router.push({ name: 'product_cost' })
    },
    async onDelete() {
      if (!confirm('作業日報を削除しますがよろしいですか？')) {
        return
      }
      const { data } = await axios.delete('/api/productcost/' + this.product_cost.id)
      this.onBack()
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
label {
  // color: $gray-800;
  border-left: solid 5px $warning;
  padding-left: 10px;
}
.btn-super {
  padding-top: 1.8rem;
  padding-bottom: 1.8rem;
  font-size: 2rem;
}
.btn-super2 {
  padding-top: 1rem;
  padding-bottom: 1rem;
  font-size: 2rem;
}
.btn-super3 {
  opacity: 0.8;
}
.saving button {
  margin: 0;
  padding: 5;

  position: fixed;
  right: 80px;
  bottom: 100px;
  z-index: 99;
}
</style>
<style lang="css">
.multiselect__tag {
  margin-bottom: 0;
}
</style>
