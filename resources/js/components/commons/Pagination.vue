<template>
  <div>
    <vue-ads-pagination
      :total-items="value.total_items"
      :max-visible-pages="value.max_visible_pages"
      :page="value.page"
      :items-per-page="value.items_per_page"
      :loading="loading"
      @page-change="pageChange"
    >
      <template slot-scope="props">
        <div class="vue-ads-pr-2 vue-ads-leading-loose">
          {{ props.total }} 件中 {{ props.start }} ～ {{ props.end }} 件目を表示
        </div>
      </template>
      <template slot="buttons" slot-scope="props">
        <vue-ads-page-button
          v-for="(button, key) in props.buttons"
          :key="key"
          v-bind="button"
          @page-change="value.page = button.page"
        />
      </template>
    </vue-ads-pagination>
  </div>
</template>

<script>
import VueAdsPagination, { VueAdsPageButton } from 'vue-ads-pagination'

export default {
  components: {
    VueAdsPagination,
    VueAdsPageButton,
  },
  props: ['totalItems', 'maxVisiblePages', 'page', 'itemsPerPage'],
  data() {
    return {
      loading: false,
      value: {
        total_items: 1,
        max_visible_pages: 5,
        page: 0,
        items_per_page: 10,
      },
    }
  },
  watch: {
    page: function(val, oldVal) {
      this.value.page = this.page
    },
    totalItems: function(val, oldVal) {
      this.value.total_items = this.totalItems
    },
  },
  mounted: function() {
    this.value.total_items = this.totalItems
    this.value.max_visible_pages = this.maxVisiblePages
    this.value.page = this.page
    this.value.items_per_page = this.itemsPerPage
  },
  methods: {
    pageChange(page, start, end) {
      // console.log(page, start, end);
      this.$emit('pageChange', page, start, end)
    },
  },
}
</script>

<style lang="scss" scoped>
@import 'resources/sass/variables';
/*! normalize.css v7.0.0 | MIT License | github.com/necolas/normalize.css */

html {
  line-height: 1.15;
  -ms-text-size-adjust: 100%;
  -webkit-text-size-adjust: 100%;
}

figcaption,
main,
nav,
section {
  display: block;
}

strong {
  font-weight: inherit;
  font-weight: bolder;
}

dfn {
  font-style: italic;
}

button,
input {
  font-family: sans-serif;
  font-size: 100%;
  line-height: 1.15;
  margin: 0;
  overflow: visible;
}

button {
  text-transform: none;
}

[type='reset'],
[type='submit'],
button,
html [type='button'] {
  -webkit-appearance: button;
}

[type='button']::-moz-focus-inner,
[type='reset']::-moz-focus-inner,
[type='submit']::-moz-focus-inner,
button::-moz-focus-inner {
  border-style: none;
  padding: 0;
}

[type='button']:-moz-focusring,
[type='reset']:-moz-focusring,
[type='submit']:-moz-focusring,
button:-moz-focusring {
  outline: 1px dotted ButtonText;
}

legend {
  color: inherit;
  display: table;
  max-width: 100%;
  white-space: normal;
}

[type='checkbox'],
[type='radio'],
legend {
  box-sizing: border-box;
  padding: 0;
}

[type='number']::-webkit-inner-spin-button,
[type='number']::-webkit-outer-spin-button {
  height: auto;
}

[type='search'] {
  -webkit-appearance: textfield;
  outline-offset: -2px;
}

[type='search']::-webkit-search-cancel-button,
[type='search']::-webkit-search-decoration {
  -webkit-appearance: none;
}

::-webkit-file-upload-button {
  -webkit-appearance: button;
  font: inherit;
}

menu {
  display: block;
}

canvas {
  display: inline-block;
}

[hidden],
template {
  display: none;
}

html {
  box-sizing: border-box;
  font-family: sans-serif;
}

*,
:after,
:before {
  box-sizing: inherit;
}

button {
  background: transparent;
  padding: 0;
}

button:focus {
  outline: 1px dotted;
  outline: 5px auto -webkit-focus-ring-color;
}

*,
:after,
:before {
  border-width: 0;
  border-style: solid;
  border-color: #dae1e7;
}

[type='button'],
[type='reset'],
[type='submit'],
button {
  border-radius: 0;
}

button,
input {
  font-family: inherit;
}

input::placeholder {
  color: inherit;
  opacity: 0.5;
}

[role='button'],
button {
  cursor: pointer;
}

.vue-ads-bg-grey-light {
  background-color: #dae1e7;
}

.vue-ads-bg-grey-lighter {
  background-color: #f1f5f8;
}

.vue-ads-bg-teal-dark {
  background-color: #38a89d;
}

.hover\:vue-ads-bg-grey-lighter:hover {
  background-color: #f1f5f8;
}

.vue-ads-cursor-default {
  cursor: default;
}

.vue-ads-flex {
  display: flex;
}

.vue-ads-justify-end {
  justify-content: flex-end;
}

.vue-ads-flex-grow {
  flex-grow: 1;
}

.vue-ads-leading-normal {
  line-height: 1.5;
}

.vue-ads-leading-loose {
  line-height: 2;
}

.vue-ads-m-2 {
  margin: 0.5rem;
}

.vue-ads-ml-1 {
  margin-left: 0.25rem;
}

.focus\:vue-ads-outline-none:focus,
.vue-ads-outline-none {
  outline: 0;
}

.vue-ads-px-0 {
  padding-left: 0;
  padding-right: 0;
}

.vue-ads-pr-2 {
  padding-right: 0.5rem;
}

.vue-ads-text-grey {
  color: #b8c2cc;
}

.vue-ads-text-white {
  color: #fff;
}

.vue-ads-text-xs {
  font-size: 0.75rem;
}

.vue-ads-w-6 {
  width: 1.5rem;
}
</style>
<style>
.vue-ads-flex {
  display: flex;
}

.vue-ads-justify-end {
  justify-content: flex-end;
}

.vue-ads-flex-grow {
  flex-grow: 1;
}
</style>
