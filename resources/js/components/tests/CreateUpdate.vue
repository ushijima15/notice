/* eslint-disable */
<template>
  <div class="container">
    <div class="mr-auto">
      <span class="span-header">{{ title }}</span>
      <br />
      <button type="button" class="btn btn-primary" @click="onBack">戻る</button>
    </div>
    <br />
    <div v-for="tweet in tweets" :key="tweet.id" class="clickable">
      <div
        v-if="tweetId === tweet.id || test.tweet_id === tweet.id"
        style="padding: 10px; margin-bottom: 10px; border: 5px double #333333; border-radius: 10px; background-color: #ffff99;"
      >
        <p>投稿者ID:{{ tweet.id }}</p>
        <p>本文{{ tweet.text }}</p>
      </div>
    </div>
    <div class="reply">
      <input v-model="test.text" class="reply2" type="text" />
      <div class="reply3">
        <button type="button" class="btn btn-primary" @click="onBack">送信の取り消し</button>
        <button type="button" class="btn btn-primary" @click="onStore">送信する</button>
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
  props: ['tweetId', 'testId'],
  data() {
    return {
      test: {
        id: null,
        tweet_id: null,
        text: '',
      },
      tweets: [],
      invalid: false,
      errorMessage: '',
      isLoading: false,
      fullPage: false,
    }
  },
  computed: {
    title: function() {
      return this.mode === 'create' ? '新規作成' : '編集'
    },
    mode: function() {
      return this.testId ? 'update' : 'create'
    },
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
      const api2 = axios.create()
      axios.all([api2.get('/api/tweet')]).then(
        axios.spread((res5, res6, res7, res8) => {
          this.tweets = res5.data
          this.isLoading = false
        }),
      )
      if (this.mode === 'create') {
        this.isLoading = false
      } else {
        axios.all([api.get('/api/test/' + this.testId)]).then(
          axios.spread((res1, res2, res3, res4) => {
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
      if (this.mode === 'create') {
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
        this.isLoading = false
      } else {
        alert('確認')
        axios
          .put('/api/test/' + this.test.id, {
            test: this.test,
          })
          .then(function(resp) {
            if (resp.data.result) {
              alert('更新しました。')
              _this.$router.go(-1)
            } else {
              alert('確認2')
              _this.errorMessage = resp.data.errorMessage
              _this.invalid = true
            }
          })
          .catch(function(resp) {
            console.log(resp)
          })
      }
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
