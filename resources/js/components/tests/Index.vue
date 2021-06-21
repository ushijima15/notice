/* eslint-disable */
<template>
  <div v-cloak class="container">
    <div>
      <button type="button" class="btn btn-primary" @click="onBack">戻る</button>
      ログインユーザー:{{ username }}
      <span data-popup="Like" class="like reaction"></span>
      <hr />
    </div>
    <div>
      <div
        v-for="tweet in tweets"
        :key="tweet.id"
        class="clickable"
        style="
          padding: 10px;
          margin-bottom: 10px;
          border: 5px double #333333;
          border-radius: 10px;
          background-color: #ffff99;
        "
      >
        <p>投稿者:{{ tweet.user_name }}</p>
        <p>本文</p>
        <p>{{ tweet.text }}</p>
        <div>
          <nobr>
            <!--<button
              v-if="tweet.own_like === 0"
              type="button"
              class="btn btn-success text-center align-middle"
              @click="onAddgood(tweet.id)"
            >
              いいね!
            </button>
            <button
              v-else
              type="button"
              class="btn btn-secondary text-center align-middle"
              @click="onDeletegood(tweet.id)"
            >
              いいね済み
            </button>-->
            <a
              v-if="tweet.own_like_good === 0"
              slot="icon"
              class="fas fa-thumbs-up fa-lg"
              style="color: #c0c0c0"
              @click="onAddgood(tweet.id, 1)"
            ></a>
            <a
              v-else
              slot="icon"
              class="fas fa-thumbs-up fa-lg"
              style="color: #00bfff"
              @click="onDeletegood(tweet.id, 1)"
            ></a>
            {{ tweet.count_good }}
            <a
              v-if="tweet.own_like_heart === 0"
              slot="icon"
              class="far fa-heart fa-lg"
              style="color: #ff00ff"
              @click="onAddgood(tweet.id, 2)"
            ></a>
            <a
              v-else
              slot="icon"
              class="fas fa-heart fa-lg"
              style="color: #ff00ff"
              @click="onDeletegood(tweet.id, 2)"
            ></a>
            {{ tweet.count_heart }}
            <a
              v-if="tweet.own_like_check === 0"
              slot="icon"
              class="far fa-check-square fa-lg"
              style="color: #c0c0c0"
              @click="onAddgood(tweet.id, 3)"
            ></a>
            <a
              v-else
              slot="icon"
              class="fas fa-check-square fa-lg"
              style="color: #00ff00"
              @click="onDeletegood(tweet.id, 3)"
            ></a>
            {{ tweet.count_check }}
            <button type="button" class="btn btn-primary text-center align-middle" @click="onNext(tweet.id)">
              返信する
            </button>
          </nobr>
        </div>
        <hr />
        <div v-if="tweet.comment_visusal === true" @click="visual(tweet.comment_visusal, tweet.id)">
          &#9650;投稿内容の返信を非表示。
        </div>
        <div v-if="tweet.comment_visusal === false" @click="visual(tweet.comment_visusal, tweet.id)">
          &#9660;投稿内容の返信を表示。
        </div>
        <div v-if="tweet.comment_visusal === true">
          <div v-for="test in tests" :key="test.id">
            <div v-if="tweet.id === test.tweet_id">
              <hr />
              <p>返信者:{{ test.user_name }}</p>
              <p>本文:{{ test.text }}</p>
              <button
                v-if="test.user_id === userid"
                type="button"
                class="btn btn-primary text-center align-middle"
                @click="onShow(test.id, tweet.id)"
              >
                編集
              </button>
              <button
                v-if="test.user_id === userid"
                type="button"
                class="btn btn-primary text-center align-middle"
                @click="onDelete(test.id)"
              >
                削除
              </button>
            </div>
          </div>
        </div>
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
      tests: [],
      tweets: [],
      isLoading: false,
      count: '',
      result: false,
      userid: null,
      username: '',
      message: null,
      isActive: false,
    }
  },
  computed: {},
  watch: {
    getItems: function() {
      return this.getItems
    },
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
      const api4 = axios.create()
      axios.all([api4.get('/api/like/userid')]).then(
        axios.spread((res1, res2, res3, res4) => {
          this.userid = res1.data
          this.isLoading = false
        }),
      )
      const api5 = axios.create()
      axios.all([api5.get('/api/like/username')]).then(
        axios.spread((res1, res2, res3, res4) => {
          this.username = res1.data
          this.isLoading = false
        }),
      )
    },
    toggle_switch: function() {
      alert(this.isActive)
      this.isActive = !this.isActive
    },
    onNext: function(tweet_id) {
      this.message = this.$router.push({ name: 'test.create', params: { tweetId: tweet_id } })
    },
    onShow: function(test_id, tweet_id) {
      this.$router.push({ name: 'test.show', params: { testId: test_id, tweetId: tweet_id } })
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
    onDeletegood: function(tweet_id, mark) {
      this.message = tweet_id
      const _this = this
      axios
        .delete('/api/tweet/deletegood/' + this.message + '/' + mark)
        .then(function(resp) {})
        .catch(function(resp) {
          console.log(resp)
        })
        .finally(function() {
          //
        })
      if (mark === 1) {
        this.tweets[this.message - 1].own_like_good = 0
        this.tweets[this.message - 1].count_good -= 1
      }
      if (mark === 2) {
        this.tweets[this.message - 1].own_like_heart = 0
        this.tweets[this.message - 1].count_heart -= 1
      }
      if (mark === 3) {
        this.tweets[this.message - 1].own_like_check = 0
        this.tweets[this.message - 1].count_check -= 1
      }
    },
    onAddgood: function(tweet_id, mark) {
      this.message = tweet_id
      this.invalid = false
      this.errorMessage = ''
      const _this = this
      axios
        .get('/api/tweet/addgood/' + this.message + '/' + mark)
        .then(function(resp) {})
        .catch(function(resp) {
          console.log(resp)
        })
      if (mark === 1) {
        this.tweets[this.message - 1].own_like_good = 1
        this.tweets[this.message - 1].count_good += 1
      }
      if (mark === 2) {
        this.tweets[this.message - 1].own_like_heart = 1
        this.tweets[this.message - 1].count_heart += 1
      }
      if (mark === 3) {
        this.tweets[this.message - 1].own_like_check = 1
        this.tweets[this.message - 1].count_check += 1
      }
    },
    visual: function(visable, number) {
      visable = !visable
      this.tweets[number - 1].comment_visusal = visable
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
[v-cloak] {
  display: none;
}
</style>
