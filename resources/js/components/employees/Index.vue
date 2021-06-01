<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
              <div class="mr-auto">
                <span class="span-header">従業員一覧</span>
              </div>
              <div class="align-self-center mr-3">
                <button type="button" class="btn btn-primary" @click="onCreate">
                  <i class="fas fa-plus"></i> 新規追加
                </button>
              </div>
              <div class="align-self-center">
                <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
              </div>
            </div>

            <table key="processes" class="table-custom">
              <thead>
                <!-- todo -->
                <tr>
                  <td class="text-center align-middle">名前</td>
                  <td class="text-center align-middle">フリガナ</td>
                  <td class="text-center align-middle">ID</td>
                  <td class="text-center align-middle">権限</td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="employee in employees" :key="employee.id" class="clickable" @click="onShow(employee.id)">
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
  </div>
</template>

<script>
import moment from 'moment'
export default {
  components: {
    // Loading
  },
  props: [],
  data() {
    return {
      employees: [],
      isLoading: false,
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
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
</style>
