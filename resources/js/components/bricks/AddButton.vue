<template>
    <input style="padding-right: 5px" type="image" class="button" src="img/iconfinder_add.png" @click="$emit('click')">
</template>

<script>
    export default {
        name: "AddButton",
    }
</script>

<style lang="sass" scoped>
    .button
        background-color: rgba(0, 0, 0, 0)
        width: 16px
        height: 16px
        padding: 5px 0 0px 5px
        margin: 5px 0 0px 5px
</style>
