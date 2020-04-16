<template>
    <div class="thin-border form-row">
        <div style="display: flex; justify-content: space-between">
            <h5 style="align-self: center; padding-left: 10px">{{caption}}</h5>
            <ExpandDownButton @click="show=!show" style="justify-self: right; padding-right: 5px"></ExpandDownButton>
        </div>
        <div class="row-content" v-show="show" style="padding:0 4px 0 4px" @confirmed="$emit('confirmed', $event)"><slot></slot></div>
    </div>
</template>

<script>
    import ExpandDownButton from "./ExpandDownButton";

    export default {
        name: "EditableRowContainer",
        components: {
            ExpandDownButton,
        },
        props: {
            caption: null,
        },
        data () {
            return {
                show: false
            }
        },
    }
</script>

<style lang="sass" scoped>
    @use 'resources/sass/base'
    .row-content
        background-color: base.$color3
        border: 2px solid base.$color6
</style>
