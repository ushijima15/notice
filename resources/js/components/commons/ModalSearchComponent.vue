<template>
  <div style=" ;">
    <!-- <div class="d-flex"> -->
    <div v-if="label" class="align-self-center mr-3">
      {{ label }}
    </div>
    <div>
      <div class="input-group">
        <!-- @blur="onFind" 15rem width:16rem;-->
        <!-- <input type="input" class="form-control" style="" v-model="name" > -->
        <div class="input-group-append">
          <!-- <button class="btn btn-primary" type="button" id="button-addon2" @click="show">コード・品名を検索<i class="fas fa-search ml-1"></i></button> -->
          <input v-model="name" type="input" class="form-control" @click="show" />
        </div>
      </div>
    </div>
    <!-- <div class="align-self-center ml-2" v-if="selected&&!hideName">
            {{selected.name}}
        </div> -->
    <!-- </div> -->
    <modal-dialog :show="showModal" @close="showModal = false">
      <template #header>
        <div class="h5 mb-0">{{ title }}</div>
      </template>
      <template #body>
        <slot name="body">
          <div class="mt-2">
            <div class="row mb-2">
              <div class="col-sm-2 align-self-center">製番ＣＤ</div>
              <div class="col-sm-10">
                <input v-model="search_code" type="text" class="form-control" @keydown.enter="onSearch" />
              </div>
            </div>
            <div class="row">
              <div class="col-sm-2 align-self-center">件名</div>
              <div class="col-sm-10">
                <input v-model="search_name" type="text" class="form-control" @keydown.enter="onSearch" />
              </div>
            </div>
          </div>
          <slot name="search"> </slot>
          <div class="mt-2">
            <div class="d-flex justify-content-end">
              <button
                class="btn btn-primary ml-1"
                type="button"
                :disabled="!search_code && !search_name"
                @click="onSearch"
              >
                検索
              </button>
            </div>
          </div>
          <div class="mt-3">
            <table class="table table-sm">
              <thead>
                <th class="text-center">製番ＣＤ</th>
                <th class="text-center">件名</th>
              </thead>
              <tbody>
                <tr
                  v-for="(item, index) in paginateItems"
                  :key="index"
                  :class="{ 'selected-row': item.selected }"
                  @click="onClick(index)"
                >
                  <td class="text-center">{{ item.code }}</td>
                  <td class="text-center">{{ item.name }}</td>
                </tr>
              </tbody>
            </table>
            <mg-paginate :data="items" :count-per-page="countPerPage" @change="paginateItems = $event"></mg-paginate>
          </div>
        </slot>
      </template>
      <template #footer>
        <button type="button" class="btn btn-danger" :disabled="is_selected" @click="clear">クリア</button>
        <button type="button" class="btn btn-primary" :disabled="!is_selected" @click="ok">ＯＫ</button>
        <button type="button" class="btn btn-secondary" @click="showModal = false">キャンセル</button>
      </template>
    </modal-dialog>
  </div>
</template>

<script>
export default {
  props: {
    title: {
      default: '検索',
    },
    label: {
      default: '',
    },
    value: {
      default: {
        // id: null,
        // name: '',
        // code: '',
      },
    },
    hideName: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      items: [],
      showModal: false,
      name: '',
      code: '',
      search_code: '',
      search_name: '',
      selected: {},
      is_selected: false,

      paginateItems: [],
      countPerPage: 8,
    }
  },
  watch: {
    //
  },
  mounted: function() {
    this.items = []
    this.name = this.value.name
    this.code = this.value.code
    this.selected = this.value
  },
  methods: {
    show: function() {
      this.init()
      this.showModal = true
    },
    init: function() {
      this.items = []
      this.search_number = ''
      this.is_selected = false
    },
    onSearch: function() {
      this.$emit('search', this.search_code, this.search_name, this.callback)
    },
    callback: function(data) {
      this.is_selected = false
      this.items = data
    },

    ok: function() {
      this.showModal = false
      this.name = this.selected
      // this.code = this.selected.code
      this.$emit('input', this.selected)
    },
    onClick: function(index) {
      this.is_selected = true
      const item = this.paginateItems[index]
      this.selected = item.name
      this.paginateItems.forEach(function(value) {
        value.selected = false
      })
      item.selected = true
      this.paginateItems.splice(index, 1, item)
    },
    clear: function() {
      this.items = []
      this.search_code = ''
      this.search_name = ''
      this.name = ''
      this.selected = ''
      // this.code = this.selected.code
      this.$emit('input', this.selected)
    },
  },
}
</script>

<style scope>
.selected-row {
  background-color: #ffecb3 !important;
}
</style>
