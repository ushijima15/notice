<template>
  <div>
    <transition name="view" mode="out-in">
      <router-view :key="$route.fullPath" />
    </transition>
  </div>
</template>

<script>
export default {
  created() {
    this.$store.dispatch('getUser')
  },
  methods: {
    //
  },
}
</script>

<style scope></style>
