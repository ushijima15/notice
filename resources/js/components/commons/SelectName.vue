<template>
  <div class="d-flex flex-wrap">
    <div v-for="employee in employees" :key="employee.id" class="card card-tab">
      <div class="card-body">
        <button type="button" class="btn btn-lg btn-link btn-select" @click="onClick(employee)">
          {{ employee.full_name }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['employees'],
  methods: {
    onClick: function(item) {
      this.$emit('selected', item)
    },
  },
}
</script>

<style scoped>
.card-tab {
  box-shadow: none;
  border: none;
}
.card-body {
  padding: 0.9rem;
}
.btn-select {
  font-size: 1.5rem;
}
</style>
