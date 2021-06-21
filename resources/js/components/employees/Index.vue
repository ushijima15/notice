/* eslint-disable */
<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
              <h3 class="mr-auto">作業員一覧</h3>
              <div class="align-self-center mr-3">
                <button type="button" class="btn btn-primary" @click="onCreate">新規追加</button>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
              </div>
            </div>
            <table key="processes" class="table table-striped">
              <thead>
                <!-- todo -->
                <tr>
                  <td class="text-center bg-primary text-white">名前</td>
                  <td class="text-center bg-primary text-white">フリガナ</td>
                  <td class="text-center bg-primary text-white">ID</td>
                  <td class="text-center bg-primary text-white">権限</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees" :key="employee.id" @click="onShow(employee.id)">
                  <td class="text-center align-middle">{{ employee.full_name }}</td>
                  <td class="text-center align-middle">{{ employee.full_phonetic_name }}</td>
                  <td class="text-center align-middle">{{ employee.user_name }}</td>
                  <td class="text-center align-middle">
                    <div v-if="employee.is_admin">管理者</div>
                    <div v-if="employee.is_leader">リーダー</div>
                  </td>
                </tr>
              </tbody>
              <loading :active.sync="isLoading"></loading>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div>
      <!--<p>いいねボタン実装</p>
      <button v-if="isActive === false" class="good" @click="toggle_switch()">&#9825;</button>
      <button v-if="isActive === true" class="good" @click="toggle_switch()">&#9829;</button>
      <button v-if="isActive2 === true" class="good2" @click="toggle_switch2()">&#x1f44d;</button>
      <button v-if="isActive2 === false" @click="toggle_switch2()">&#x1f44d;</button>
      <button v-if="status === false" type="button" class="btn btn-outline-warning" @click.prevent="like_check">
        &#9825;
      </button>
      <a v-if="status == false" href="#">{{ count }}</a>
      <button v-else type="button" class="btn btn-warning" @click.prevent="like_check">
        &#9829;
      </button>
      <a v-if="status === true" href="#">
        {{ count }}
      </a>-->

      <a
        v-if="isActive === true"
        slot="icon"
        class="fas fa-check-square"
        style="color: #00ff00"
        @click="toggle_switch()"
      ></a>
      <a v-else slot="icon" class="far fa-check-square" style="color: #c0c0c0" @click="toggle_switch()"></a>
      <!--
      <a slot="icon" class="fa fa-heart" color="#000000" @click="toggle_switch()"></a>
      <div>
        <vue-star animate="animated rubberBand">
          <a slot="icon" class="fa fa-heart" color="#F05654" @click="handleClick"></a>
        </vue-star>
        <vue-star animate="animated rubberBand" color="#000000">
          <a slot="icon" class="fa fa-heart" @click="handleClick"></a>
        </vue-star>
      </div>
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
  data() {
    return {
      employees: [],
      isActive: false,
      isActive2: false,
      isLoading: false,
      status: false,
      count: 0,
    }
  },
  computed: {
    //
  },
  watch: {
    //
  },
  created() {},
  mounted() {
    // this.inspected_on = new moment().format('YYYY-MM-DD')
    this.getItems()
  },
  methods: {
    toggle_switch: function() {
      alert(this.isActive)
      this.isActive = !this.isActive
    },
    toggle_switch2: function() {
      this.isActive2 = !this.isActive2
    },
    getItems: function() {
      this.isLoading = true
      const api = axios.create()
      axios.all([api.get('/api/employee')]).then(
        axios.spread((res1, res2, res3, res4) => {
          this.employees = res1.data

          this.isLoading = false
        }),
      )
    },
    onCreate: function() {
      this.$router.push({ name: 'employee.create' })
    },
    onShow: function(employee_id) {
      this.$router.push({ name: 'employee.show', params: { employeeId: employee_id } })
    },
    onBack: function() {
      this.$router.go(-1)
    },
    handleClick: function() {},
  },
}
</script>
<style lang="scss" scoped>
@import 'resources/sass/variables';
</style>
