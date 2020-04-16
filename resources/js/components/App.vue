<template>
    <div id="app" :style="'grid-template-rows: 64px '+contentHeight+'px 42px'">
        <div id="header" class="section-floater">
            <Header></Header>
        </div>
        <div id="nav" class="section-floater">
            <NavBar></NavBar>
        </div>
        <div id="content" class="section-floater">
            <router-view :height="contentHeight-30"></router-view>
        </div>
        <div id="footer" class="section-floater">
            <span>Your Company</span>
        </div>
    </div>
</template>

<script>
    import BrowseAccounts from "./BrowseAccounts";
    import NavBar from "./NavBar";
    import Header from "./Header";
    import Utils from "../Utils";

    export default {
        components: {
            Header,
            NavBar,
            BrowseAccounts
        },
        data () {
            return {
            }
        },
        methods: {
        },
        computed: {
            contentHeight () {
                return Utils.pixelByPercent(Utils.getScreenHeight(), 77)
            }
        }
    }
</script>

<style lang="sass" scoped>
    #app
        display: grid
        grid-template-columns: 300px auto
        grid-gap: 20px

    #header
        grid-column-start: 1
        grid-column-end: 2
        grid-row-start: 1
        grid-row-end: 2
        padding: 10px
        background-color: rgba(12, 20, 70, 0.72) //theme.$transparent-blue

    #content
        grid-column-start: 2
        grid-column-end: 3
        grid-row-start: 1
        grid-row-end: 3
        padding: 10px 10px 15px 10px

    #nav
        grid-column-start: 1
        grid-column-end: 2
        grid-row-start: 2
        grid-row-end: 3
        padding: 10px

    #footer
        grid-column-start: 1
        grid-column-end: 3
        grid-row-start: 3
        grid-row-end: 4
        padding: 10px

</style>
