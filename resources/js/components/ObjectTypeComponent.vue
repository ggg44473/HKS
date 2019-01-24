<template>
  <div>
    <label class="mb-0">執行人</label>
    <model-list-select
      class="form-control"
      :list="memberList"
      option-value="name"
      option-text="name"
      v-model="selectedMember"
      placeholder="請選擇執行人"
      @searchchange="searchMember"
    ></model-list-select>
    <input type="hidden" name="invite" v-bind:value="selectedMember.id">
  </div>
</template>

<script>
import { ModelListSelect } from "vue-search-select";

export default {
  data() {
    return {
      memberList: [],
      selectedMember: {},
      searchText: ""
    };
  },
  props: ["api"],
  created() {
    this.searchMember();
  },
  methods: {
    searchMember() {
      if (this.memberList.length === 0) {
        axios
          .get(this.api)
          .then(response => {
            this.memberList = response.data;
          })
          .catch(error => {});
      }
    }
  },
  components: {
    ModelListSelect
  }
};
</script>
