<template>
  <div class="container">
    <div class="card">
      <div class="card-body text-center">
        <div class="h4">ページが見つかりません。</div>
        <div>
          <button type="button" class="btn btn-lg btn-link" @click="onBack">戻る</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    onBack: function() {
      this.$router.replace({ path: '/' })
    },
  },
}
</script>

<style lang="scss" scoped></style>
