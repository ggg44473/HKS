<template>
    <div class="row justify-content-md-center">
        <div class="col-sm-10">邀請成員</div>        
        <div class="col-sm-8">
            <multi-list-select :list="memberList"
                            option-value="email"
                            option-text="email"
                            :custom-text="nameAndEmail"
                            :selected-items="items"
                            placeholder="請輸入姓名/信箱"
                            @select="onSelect"
                            @searchchange="printSearchText">
            </multi-list-select>    
        </div>
        <div class="col-sm-2">
            <button type="submit" class="btn btn-primary">邀請</button>
        </div>
        <input type="hidden" name="invite" v-bind:value="itemsID">
    </div>
</template>

<script>
  import unionWith from 'lodash/unionWith'
  import isEqual from 'lodash/isEqual'
  import { MultiListSelect } from 'vue-search-select'
  
  export default {
    data () {
      return {
        memberList: [],
        items: [],
        itemsID: [],
        searchText: ''
      }
    },
    props: ['api'],
    created () {
      this.searchMember()
    },
    methods: {
      nameAndEmail (item) {
        return `${item.name} - ${item.email}`
      },
      onSelect (items, itemsID) {
        this.items = items
        if (this.itemsID.includes(itemsID.id)) {
            this.itemsID.splice(this.itemsID.length-1,1)
            console.log('delete')
        } else {
            this.itemsID.push(itemsID.id)            
        }
      },
      printSearchText (searchText) {
        this.searchText = searchText
      },
      searchMember () {
        if (this.memberList.length === 0) {
          axios.get(this.api)
            .then(response => {
              this.memberList = response.data
            })
            .catch(error => {
            })
        }
      },
    },
    components: {
      MultiListSelect
    }
  }
</script>
