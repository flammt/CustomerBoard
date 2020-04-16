<template>
    <div id="form-row" class="form-row">
        <h5 :class="{'error': isError}" :style="{'height': rowHeight+'px'}"><slot></slot></h5>
    </div>
</template>

<script>
    export default {
        name: "FormValidationRow",
        props: {
            isError: true,
            height: 0,
        },
        data () {
            return {
            }
        },
        computed: {
            rowHeight () {
                return this.height-6;
            }
        },
        mounted () {
        },
        updated() {
        }
    }
</script>

<style lang="sass" scoped>
    #form-row
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
    .standard
        color: midnightblue
    .error
        color: darkred
</style>
