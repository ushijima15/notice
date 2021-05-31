<template>
  <div class="back-button">
    <slot></slot>
    <button type="button" class="btn btn-dark" @click="onBack">戻る</button>
  </div>
</template>

<script>
export default {
  components: {
    //
  },
  props: ['backName'],
  data() {
    return {
      //
    }
  },
  computed: {
    //
  },
  watch: {
    //
  },
  mounted: function() {
    // console.log(this.value)
  },
  methods: {
    onBack: function() {
      if (this.back_name) {
        this.$router.push({ name: this.backName })
      } else {
        this.$router.go(-1)
      }
    },
  },
}
</script>

<style lang="scss">
@import 'resources/sass/variables';
.back-button {
  position: absolute;
  top: 20px;
  right: 20px;
}
</style>
