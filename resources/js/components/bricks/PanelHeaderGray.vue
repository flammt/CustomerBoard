<template>
    <div id="panel-header">
        <h5><slot></slot></h5>
    </div>
</template>

<script>
    export default {
        name: "PanelHeaderGray",
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
        padding: 0 0px 0 0
        margin: 5px 0 0px 0
        font-size: 14px
        color: rgb(93, 93, 134)
        //theme.$panel-text
        font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif

</style>
