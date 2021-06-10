/* eslint-disable */
<template>
  <div class="container">
    <div>
      <button type="button" class="btn btn-primary" @click="onBack">戻る</button>
      <hr />
    </div>
    <div>
      <p>投稿内容</p>
      <div
        v-for="tweet in tweets"
        :key="tweet.id"
        class="clickable"
        style="padding: 10px; margin-bottom: 10px; border: 5px double #333333; border-radius: 10px; background-color: #ffff99;"
      >
        <p>投稿者ID:{{ tweet.id }}</p>
        <p>本文{{ tweet.text }}</p>
        <button type="button" class="btn btn-primary text-center align-middle" @click="onNext(tweet.id)">
          返信する
        </button>
        <hr />
        <div v-for="test in tests" :key="test.id">
          <div v-if="tweet.id === test.tweet_id">
            <p>投稿者ID:{{ test.id }}</p>
            <p>返信者:</p>
            <p>本文:{{ test.text }}</p>
            <button type="button" class="btn btn-primary text-center align-middle" @click="onShow(test.id)">
              編集
            </button>
            <button type="button" class="btn btn-primary text-center align-middle" @click="onDelete(test.id)">
              削除
            </button>
            <hr />
          </div>
        </div>
      </div>
      <!--
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
      -->
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
    onShow: function(test_id) {
      this.message = test_id
      this.$router.push({ name: 'test.show', params: { testId: this.message } })
    },
    onBack() {
      this.$router.go(-1)
    },
    onDelete: function(test_id) {
      this.message = test_id
      if (!confirm('削除してもよろしいですか？')) {
        return
      }
      location.reload()
      const _this = this
      axios
        .delete('/api/test/' + this.message)
        .then(function(resp) {
          alert('削除しました。')
        })
        .catch(function(resp) {
          console.log(resp)
        })
        .finally(function() {
          //
        })
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
