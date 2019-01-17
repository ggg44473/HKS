<template>
    <div class="row u-ml-32 u-mr-32">
        <div class="form-row">
            <div class="form-group col-md-11">
                <label for="company_member">邀請成員<strong class="invalid-feedback"></strong></label>
                <input type="text" v-model="keywords" placeholder="請輸入成員名稱/信箱" class="form-control">
            </div>
            <!-- <div class="col-md-1 align-self-end text-center"><i id="addMember" class="fas fa-plus-circle"></i></div> -->
            <div v-if="results.length > 0 && keywords.length > 0" class="mt-2">
                <a v-for="result in results" :key="result.id" class="dropdown-item">
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
            return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
        }
    }
}
</script>
