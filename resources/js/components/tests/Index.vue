/* eslint-disable */
<template>
  <div class="container">
    <div>
      <button type="button" class="btn btn-primary" @click="onNext">戻る</button>
    </div>
    <div>
      <p>投稿内容</p>
      <table key="processes" class="table table-striped">
        <thead>
          <tr>
            <td class="text-center bg-primary text-white">投稿者ID</td>
            <td class="text-center bg-primary text-white">投稿</td>
            <td class="text-center bg-primary text-white">ボタン</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="tweet in tweets" :key="tweet.id" class="clickable">
            <td class="text-center align-middle">{{ tweet.id }}</td>
            <td class="text-center align-middle">{{ tweet.text }}</td>
            <button type="button" class="btn btn-primary text-center align-middle" @click="onNext(tweet.id)">
              返信する
            </button>
          </tr>
        </tbody>
        <loading :active.sync="isLoading"></loading>
      </table>
      <p>返信内容</p>
      <table key="processes" class="table table-striped">
        <thead>
          <tr>
            <td class="text-center bg-primary text-white">投稿者ID</td>
            <td class="text-center bg-primary text-white">内容</td>
            <td class="text-center bg-primary text-white">いいね</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="test in tests" :key="test.id" class="clickable">
            <td class="text-center align-middle">{{ test.tweet_id }}</td>
            <td class="text-center align-middle">{{ test.text }}</td>
            <button v-if="isActive === false" class="good" @click="toggle_switch()">&#9825;</button>
            <button v-if="isActive === true" class="good" @click="toggle_switch()">&#9829;</button>
          </tr>
        </tbody>
        <loading :active.sync="isLoading"></loading>
      </table>
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
      tests: [],
      tweets: [],
      isLoading: false,
      message: null,
      isActive: false,
    }
  },
  computed: {
    //
  },
  watch: {
    //
  },
  mounted() {
    // this.inspected_on = new moment().format('YYYY-MM-DD')
    this.getItems()
  },
  methods: {
    getItems: function() {
      this.isLoading = true
      const api = axios.create()
      axios.all([api.get('/api/test')]).then(
        axios.spread((res1, res2, res3, res4) => {
          this.tests = res1.data
          this.isLoading = false
        }),
      )
      const api2 = axios.create()
      axios.all([api2.get('/api/tweet')]).then(
        axios.spread((res5, res6, res7, res8) => {
          this.tweets = res5.data
          this.isLoading = false
        }),
      )
    },
    onNext: function(tweet_id) {
      this.message = tweet_id
      this.$router.push({ name: 'test.create', params: { tweetId: this.message } })
    },
    onBack() {
      this.$router.go(-1)
    },
    toggle_switch: function() {
      this.isActive = !this.isActive
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
</style>
