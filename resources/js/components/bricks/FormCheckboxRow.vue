<template>
    <div id="form-row" class="form-row" ref="x">
        <h5 style="align-self: center">
            <label for="checkbox"><slot></slot></label>
        </h5>
        <h5 style="justify-self: right;width:100%;text-align:left">
            <input style="text-align: left" id="checkbox" type="checkbox" :checked="checked" @change="$emit('change', $event.target.checked)">
        </h5>
    </div>
</template>

<script>
    export default {
        name: "FormCheckboxRow",
        props: {
            checked: false
        },
        data () {
            return {
            }
        },
        mounted () {
            // for scaling similar elements
            // this.$emit('pushHeight', this.$refs.x.clientHeight);
        },
        methods: {
        }
    }
</script>

<style lang="sass" scoped>
    #form-row
        display: grid
        grid-template-columns: 1fr 1fr
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
        align-items: center
    input
        margin-left: 0
</style>
