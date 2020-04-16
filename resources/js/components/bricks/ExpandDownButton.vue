<template>
    <input type="image" class="button" src="img/iconfinder-arrow-down.png" @click="$emit('click')">
</template>

<script>
    export default {
        name: "ExpandDownButton",
    }
</script>

<style lang="sass" scoped>
    .button
        background-color: rgba(0, 0, 0, 0)
        width: 20px
        height: 20px
        padding: 5px 0 5px 5px
        margin: 0px 0 0px 5px
</style>
