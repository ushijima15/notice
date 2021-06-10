/* eslint-disable */
<template>
  <div class="container">
    <div class="mr-auto">
      <span class="span-header">投稿内容</span>
      <button type="button" class="btn btn-primary" @click="onBack">戻る</button>
    </div>
    <div class="reply">
      <input v-model="test.text" class="reply2" type="text" />
      <div class="reply3">
        <button type="button" class="btn btn-primary" @click="onBack">送信の取り消し</button>
        <button type="button" class="btn btn-primary" @click="onStore">送信</button>
      </div>
    </div>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  components: {
    // Loading
  },
  props: ['tweetId'],
  data() {
    return {
      test: {
        id: null,
        tweet_id: null,
        text: '',
      },
      invalid: false,
      errorMessage: '',
      isLoading: false,
      fullPage: false,
      mode: 'create',
    }
  },
  computed: {
    //
  },
  watch: {
    //
  },
  created() {
    this.getItems()
  },
  methods: {
    getItems: function() {
      this.isLoading = true
      const api = axios.create()
      // axios.all([api.get('/api/tweet/' + this.tweetId)]).then(
      //   axios.spread((res1, res2, res3) => {
      //     this.test = res1.data
      //     this.isLoading = false
      //   }),
      // )
      if (this.mode === 'create') {
        this.isLoading = false
      } else {
        axios.all([api.get('/api/test/' + this.tweetId)]).then(
          axios.spread((res1, res2, res3) => {
            this.test = res1.data
            this.isLoading = false
          }),
        )
      }
    },
    onStore: function() {
      this.test.tweet_id = this.tweetId
      this.invalid = false
      this.errorMessage = ''
      const _this = this
      if (this.test.text === '') {
        alert('文字が入力されていません。')
        return
      }
      axios
        .post('/api/test', {
          test: this.test,
        })
        .then(function(resp) {
          if (resp.data.result) {
            alert('登録しました。')
            _this.$router.go(-1)
          } else {
            _this.errorMessage = resp.data.errorMessage
            _this.invalid = true
          }
        })
        .catch(function(resp) {
          console.log(resp)
        })
    },
    onNext() {
      this.$router.push({ name: 'test' })
    },
    onBack() {
      this.$router.go(-1)
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
</style>
