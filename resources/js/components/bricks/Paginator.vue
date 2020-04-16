<template>
    <div v-if="this.data" style="display: flex; align-items: baseline; justify-content: space-between">
        <input type="button" class="button" value="zurück" style="width:80px" @click="backward">
        <h5>{{currentPage}}/{{dataLength}}</h5>
        <input type="button" class="button" value="vor" style="width:80px" @click="forward">
    </div>
</template>

<script>
    export default {
        name: "Paginator",
        props: {
            data: null,
            page: null,
        },
        data () {
            return {
                currentPage: this.page,
            }
        },
        methods: {
            backward () {
                if (this.currentPage > 1) {
                    this.currentPage--
                }
                this.$emit('backward', this.currentPage)
            },
            forward () {
                if (this.currentPage < this.data.length) {
                    this.currentPage++
                }
                this.$emit('forward', this.currentPage)
            },
        },
        computed: {
            dataLength () {
                return this.data.length
            }
        },
        watch: {
            page () {
                this.currentPage = this.page
            }
        }
    }
</script>

<style lang="sass" scoped>
    @use 'resources/sass/base'
    h5
        color: base.$paginator-text-color
</style>