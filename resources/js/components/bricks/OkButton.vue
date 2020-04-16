<template>
    <input type="image" class="button" src="img/iconfinder-check.png" @click="$emit('click')">
</template>

<script>
    export default {
        name: "OkButton",
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
