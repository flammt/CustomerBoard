<template>
    <div id="panel-header" class="form-row">
        <h5 style="">{{message}}</h5>
    </div>
</template>

<script>
    export default {
        name: "MessageRow",
        props: {
            message: true,
        },
        data () {
            return {
            }
        },
        computed: {
        },
        mounted () {
        },
        updated() {
        }
    }
</script>

<style lang="sass" scoped>
    #panel-header
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
        font-size: 14px
        color: #906b25
        font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif
</style>
