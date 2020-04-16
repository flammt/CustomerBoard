<template>
    <div id="form-row" class="form-row">
        <h5 style="align-self: center"><label for="ta"><slot></slot></label></h5>
        <h5 style="justify-self: right;width:100%;">
            <textarea id="ta" style="width:95%;min-height: 200px" @input="$emit('input', $event.target.value)">{{value}}</textarea>
        </h5>
    </div>
</template>

<script>
    export default {
        name: "FormTextAreaRow",
        props: {
            value: ''
        },
        data () {
            return {
            }
        },
        mounted () {
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
</style>
