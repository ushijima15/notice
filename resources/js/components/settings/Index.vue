<template>
  <div class="container">
    <div class="card text-center">
      <div class="card-body">
        <back-button />
        <h3 class="title-margin mt-3 mb-5">各種設定管理</h3>
        <div class="d-flex justify-content-center mb-2">
          <router-link
            v-if="own.is_admin || own.is_time_editor"
            :to="{ name: 'csv' }"
            class="btn btn-primary btn-menu mr-3 mb-3"
            >CSV取込</router-link
          >
          <router-link
            v-if="own.is_admin"
            :to="{ name: 'employee' }"
            class="btn btn-primary btn-menu mr-3 mb-3"
            dusk="employee"
            >従業員</router-link
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
      //
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
  mounted() {
    //
  },
  methods: {
    //
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
