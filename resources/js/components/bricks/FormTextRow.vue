<template>
    <div id="form-row" class="form-row">
        <h5 style="align-self: center"><label for="name"><slot></slot></label></h5>
        <h5 style="justify-self: right;width:100%;">
            <input style="width:100%" id="name" type="text" :value="value" @input="$emit('input', $event.target.value)" @change="$emit('change', $event.target.value)">
        </h5>
    </div>
</template>

<script>
    export default {
        name: "FormTextRow",
        props: {
            value: "",
        },
        data () {
            return {
            }
        },
        mounted () {
        },
        methods: {
        },
        watch: {
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
