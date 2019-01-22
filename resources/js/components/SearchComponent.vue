<template>
    <div class="row u-ml-32 u-mr-32">
        <div class="form-row">
            <div class="form-group col-md-11">
                <label for="company_member">邀請成員<strong class="invalid-feedback"></strong></label>
                <input ref="search" type="search" v-model="keywords" placeholder="請輸入成員名稱/信箱" class="form-control" style="width: 300px;">
            </div>
            <!-- <div class="col-md-1 align-self-end text-center"><i id="addMember" class="fas fa-plus-circle"></i></div> -->
            <div role="option" v-if="results.length > 0 && keywords.length > 0" class="mt-2">
                <a v-for="result in results" :key="result.id" class="dropdown-item { active: isOptionSelected(option), highlight: index === typeAheadPointer }" @mouseover="typeAheadPointer = index">
                    <img v-bind:src="result.avatar" class="avatar-sm"/>
                    <span v-text="result.name" class="ml-2"></span>
                </a>
                
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            keywords: null,
            results: []
        };
    },

    watch: {
        keywords(after, before) {
            this.fetch();
        }
    },

    methods: {
        fetch() {
            axios.post('/organization/member/search', { keywords: this.keywords })
                .then(response => this.results = response.data)
                .catch(error => {});
        },
        highlight(text) {
            return text.replace(new RegExp(this.keywords, 'gi'), '<span class="text-red">$&</span>');
        },
        onEscape() {
            if (!this.keywords.length) {
                this.$refs.keywords.blur()
            } else {
                this.keywords = ''
            }
        },
        onSearchBlur() {
            if (this.mousedown && !this.searching) {
                this.mousedown = false
            } else {
                if (this.clearSearchOnBlur) {
                    this.search = ''
                }
                this.open = false
                this.$emit('search:blur')
            }
        },
        onSearchFocus() {
            this.open = true
            this.$emit('search:focus')
        },
    }
}
</script>
