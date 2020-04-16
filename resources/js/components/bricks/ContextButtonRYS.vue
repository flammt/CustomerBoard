<template>
    <div>
        <div v-if="sureButtons">
            <OkButton @click="ok"></OkButton>
            <CancelButton @click="cancel"></CancelButton>
        </div>
        <div v-else>
            <input type="image" class="button" src="img/gear1.png" style="width: 20px; height: 20px; padding: 0px 5px 0 8px;" @click="click" v-on-click-outside="hide">
        </div>
        <div style="position:relative" v-show="showMenu">
            <div style="position:absolute; right:12%;width:200px; float:right">
                <h5 class="link" v-for="item in menuItems" @click="action(item)">{{item.text}}</h5>
            </div>
        </div>
    </div>
</template>

<script>
    import OkButton from "./OkButton";
    import CancelButton from "./CancelButton";
    import AppState from "../../AppState";
    import Vue from "vue";

    export default {
        name: "ContextButtonRYS", //R You Sure?
        components: {
            OkButton,
            CancelButton,
        },
        props: {
            menuItems: Array,
            object: {},
        },
        data () {
            return {
                showMenu: false,
                sureButtons: false,
                selected: {},
            }
        },
        methods: {
            hide () {
                this.showMenu = false;
            },
            action (item) {
                this.selected = item;
                this.showMenu = false;
                if (item.safe) {
                    this.sureButtons = true;
                } else {
                    this.ok();
                }
            },
            ok () {
                this.sureButtons = false;
                this.$emit('select', this.selected, this.object);
            },
            cancel () {
                this.sureButtons = false;
            },
            click () {
                this.showMenu = true;
            },
        },
    }
</script>

<style lang="sass" scoped>
    .link
        cursor: pointer
        background-color: rgba(12, 20, 70, 0.72) //theme.$transparent-blue
        color: #e9c062 //theme.$sand-orange

    .link:hover
        cursor: pointer
        color: #4CAF50 //theme.$button-green

</style>