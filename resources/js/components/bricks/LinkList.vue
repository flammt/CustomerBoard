<template>
    <div id="container">
        <router-link v-for="item in items" :key="item.name" :to="item.link">
            <LinkRow @click="$emit('clicked', item)" :active="item.active">{{item.text}}</LinkRow>
        </router-link>
    </div>
</template>

<script>
    import LinkRow from "./LinkRow"

    export default {
        name: "LinkList",
        components: {
            LinkRow
        },
        props: {
            value: null,
            items: null,
        },
        data () {
            return {
                selected: this.value,
            }
        },
        methods: {
        },
        watch: {
            value () {
                this.selected = this.value
                this.items.forEach(item => {
                    item.active = false
                })
                this.selected.active = true
            }
        }
    }
</script>

<style scoped>

</style>