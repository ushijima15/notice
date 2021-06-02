<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div key="admin" class="card">
          <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
              <div class="mr-auto">
                <span class="span-header">{{ title }}</span>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
              </div>
            </div>
            <form>
              <!-- todo -->
              <div class="form-group required-label row">
                <label for="last_name" class="col-md-4 col-form-label text-md-right">姓</label>
                <div class="col-md-6">
                  <input id="last_name" v-model="employee.last_name" type="text" class="form-control" />
                </div>
              </div>
              <div class="form-group row">
                <label for="first_name" class="col-md-4 col-form-label text-md-right">名</label>
                <div class="col-md-6">
                  <input id="first_name" v-model="employee.first_name" type="text" class="form-control" />
                </div>
              </div>
              <div class="form-group row">
                <label for="last_phonetic_name" class="col-md-4 col-form-label text-md-right">カナ性</label>
                <div class="col-md-6">
                  <input
                    id="last_phonetic_name"
                    v-model="employee.last_phonetic_name"
                    type="text"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="form-group row">
                <label for="first_phonetic_name" class="col-md-4 col-form-label text-md-right">カナ名</label>
                <div class="col-md-6">
                  <input
                    id="first_phonetic_name"
                    v-model="employee.first_phonetic_name"
                    type="text"
                    class="form-control"
                  />
                </div>
              </div>
              <div class="form-group required-label row">
                <label for="user_name" class="col-md-4 col-form-label text-md-right">ユーザーID</label>
                <div class="col-md-6">
                  <input id="user_name" v-model="employee.user_name" type="text" class="form-control" />
                </div>
              </div>
              <div v-if="mode === 'create'" class="form-group required-label row">
                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                <div class="col-md-6">
                  <input id="password" v-model="employee.password" type="password" class="form-control" />
                </div>
              </div>
              <div v-else class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">パスワード</label>
                <div class="col-md-6">
                  <input id="password" v-model="employee.password" type="password" class="form-control" />
                  <div class="text-muted"><small>※変更する場合は入力してください。</small></div>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-4 text-md-right">
                  <label for="is_admin" class="col-form-label">権限の選択</label>
                </div>
                <div class="col-md-8 pt-1">
                  <div class="custom-control custom-checkbox mt-1 custom-control-inline">
                    <input id="is_admin" v-model="employee.is_admin" type="checkbox" class="custom-control-input" />
                    <label class="custom-control-label" for="is_admin">管理者</label>
                  </div>
                </div>
              </div>

              <div class="row-line">
                <transition name="fade" mode="out-in">
                  <div v-if="invalid" class="alert alert-danger" role="alert">
                    {{ errorMessage }}
                  </div>
                </transition>
              </div>
            </form>
            <div class="d-flex justify-content-start mt-4">
              <div class="mr-auto">
                <button v-if="enable_delete" type="button" class="btn btn-outline-danger" @click="onDelete">
                  この従業員を削除する
                </button>
              </div>
              <div class="mr-3">
                <button type="button" class="btn btn-dark" @click="onBack">キャンセル</button>
              </div>
              <div v-if="mode !== 'create'">
                <button type="button" class="btn btn-primary" @click="onStore">保存する</button>
              </div>
              <div v-else>
                <button type="button" class="btn btn-primary" @click="onStore">登録する</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <loading :active.sync="isLoading" :is-full-page="fullPage"></loading>
  </div>
</template>

<script>
import moment from 'moment'
export default {
  components: {
    // Loading
  },
  props: ['employeeId'],
  data() {
    return {
      employee: {
        id: '',
        first_name: '',
        last_name: '',
        last_phonetic_name: '',
        first_phonetic_name: '',
        user_name: '',
        password: '',
        is_admin: false,
      },

      invalid: false,
      errorMessage: '',

      isLoading: false,
      fullPage: false,
    }
  },
  computed: {
    own: function() {
      return this.$store.state.user
    },
    title: function() {
      return this.mode === 'create' ? '従業員の新規作成' : '従業員の編集'
    },
    mode: function() {
      return this.employeeId ? 'update' : 'create'
    },
    enable_delete: function() {
      if (this.mode === 'create') {
        return false
      }
      return this.own.employee_id !== this.employeeId
    },
  },
  watch: {},
  created() {
    this.getItems()
  },
  methods: {
    getItems: function() {
      this.isLoading = true
      const api = axios.create()
      if (this.mode === 'create') {
        this.isLoading = false
      } else {
        axios.all([api.get('/api/employee/' + this.employeeId)]).then(
          axios.spread((res1, res2, res3) => {
            this.employee = res1.data
            this.isLoading = false
          }),
        )
      }
    },
    onStore: function() {
      this.invalid = false
      this.errorMessage = ''
      // todo
      // 必須ラベルがついているものはアラートを表示させる
      // 「パスワードは4文字以上で入力してください」とアラート表示
      if (!this.employee.last_name) {
        alert('姓を入力してください。')
        this.errorMessage = '姓を入力してください。'
        this.invalid = true
        return
      }
      if (!this.employee.user_name) {
        alert('ユーザーIDを入力してください。')
        this.errorMessage = 'ユーザーIDを入力してください'
        this.invalid = true
        return
      }
      if (this.mode === 'this.mode' && !this.employee.spasword) {
        alert('パスワードを入力してください。')
        this.errorMessage = 'パスワードを入力してください。'
        this.invalid = true
        return
      }
      if (this.employee.password && this.employee.length < 4) {
        alert('パスワードは４文字以上で入力してください。')
        this.errorMessage = 'パスワードは４文字以上で入力してください。'
        this.invalid = true
        return
      }

      const _this = this
      if (this.mode === 'create') {
        axios
          .post('/api/employee', {
            employee: this.employee,
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
      } else {
        axios
          .put('/api/employee/' + this.employee.id, {
            employee: this.employee,
          })
          .then(function(resp) {
            if (resp.data.result) {
              alert('更新しました。')
              _this.$router.go(-1)
            } else {
              _this.errorMessage = resp.data.errorMessage
              _this.invalid = true
            }
          })
          .catch(function(resp) {
            console.log(resp)
          })
      }
    },
    onBack: function() {
      this.$router.go(-1)
    },
    onDelete: function() {
      if (!confirm('削除してもよろしいですか？')) {
        return
      }
      const _this = this
      axios
        .delete('/api/employee/' + this.employee.id)
        .then(function(resp) {
          alert('削除しました。')
          _this.$router.go(-1)
        })
        .catch(function(resp) {
          console.log(resp)
        })
        .finally(function() {
          //
        })
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
.row-line {
  padding-left: 1.5rem;
  padding-right: 1.5rem;
  padding-bottom: 1rem;
}
.form-content {
  width: 12rem;
  padding-left: 1rem;
  padding-right: 1rem;
  display: inline-block;
}
.form-content-lg {
  width: 15rem;
  padding-left: 1rem;
  padding-right: 1rem;
  display: inline-block;
}
.required-label label:after {
  display: inline-block;
  margin-left: 5px;
  padding: 2px 4px;
  border-radius: 3px;
  background-color: #ec5d53;
  color: #fff;
  content: '必須';
  font-size: 9px;
  line-height: 10px;
}
</style>
