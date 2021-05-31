<template>
  <div class="container">
    <div class="card text-center">
      <div class="card-body">
        <h3 class="title-margin mt-3 mb-5">メニュー</h3>
        <div class="d-flex flex-wrap justify-content-center mb-2">
          <router-link :to="{ name: 'product_cost' }" class="btn btn-primary btn-menu mr-3 mb-3"
            >作業日報一覧</router-link
          >
          <router-link
            v-show="own.is_admin || own.is_time_editor"
            :to="{ name: 'setting' }"
            class="btn btn-secondary btn-menu mr-3 mb-3"
            dusk="setting"
            >設定管理</router-link
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: [
    //
  ],
  data() {
    return {
      isLoading: false,
      barcode_url: '',
    }
  },
  computed: {
    own() {
      return this.$store.state.user
    },
  },
  watch: {
    //
  },
  async mounted() {
    await this.$store.dispatch('getUser')
    // this.connectChannel()
    this.$store.state.barcode = ''
    this.getInit()
  },
  destroyed() {
    // Echo.leave('barcode.' + this.own.id)
    // console.log('destroyed!!');
  },
  methods: {
    // connectChannel() {
    //   // console.log("connectChannel")
    //   // console.log(this.own.id)
    //   Echo.private('barcode.' + this.own.id).listen('BarcodeReceived', e => {
    //     console.log(e.payload.product_code)
    //     if (!e.payload.product_code) {
    //       let msg = '想定外のデータを受信しました。' + '\n'
    //       // msg += "product_cost_id:"+e.payload.product_cost_id+"\n"
    //       msg += 'product_code:' + e.payload.product_code + '\n'
    //       // alert('想定外のデータを受信しました。\n'.msg)
    //       alert(msg)
    //       return
    //     }
    //     this.isLoading = true
    //     setTimeout(() => {
    //       this.$store.state.barcode = e.payload.product_code
    //       // this.$router.push({ name: 'product_cost.resume', params: {'product_cost_id': e.payload.product_cost_id} }).catch(err => {})
    //       this.$router.push({ name: 'product_cost' }).catch(err => {})
    //     }, 1000)
    //   })
    // },
    getInit: function() {
      this.isLoading = true
      const api = axios.create()
      axios.all([api.get('/api/barcode/app_url')]).then(
        axios.spread((res1, res2, res3, res4) => {
          this.barcode_url = res1.data
          // if (this.own.agent_id) this.searchAgent = this.own.agent_id
          this.isLoading = false
        }),
      )
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
.btn-menu {
  height: 6rem;
  width: 9rem;
  font-size: 1rem;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
