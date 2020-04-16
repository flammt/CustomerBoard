<template>
    <div class="list-row" @mouseenter="linkActive = true" @mouseleave="linkActive = false">
        <h5 :class="linkActive ? 'link-active' : 'link'"><slot></slot></h5>
    </div>
</template>

<script>
    export default {
        name: "LinkRow",
        props: {
            active: false,
        },
        data () {
            return {
                linkActive: this.active
            }
        },
        watch: {
            active () {
                this.linkActive = this.active
            }
        }
    }
</script>

<style lang="sass" scoped>
    @use 'resources/sass/base'
    .link
        color: base.$link-color
    .link-active
        color: base.$link-hover-color
</style>
