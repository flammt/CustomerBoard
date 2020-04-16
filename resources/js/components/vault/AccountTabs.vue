<template>
    <div id="account-tabs-floater">
        <div class="tabs">
            <router-link to="/browseAccounts/account/:id/contacts">
                <div class="tab"><h5 class="tab-heading">Kontakte</h5></div>
            </router-link>
            <router-link to="/browseAccounts/account/:id/addresses">
                <div class="tab"><h5 class="tab-heading">Adressen</h5></div>
            </router-link>
            <router-link to="/browseAccounts/account/:id/reports">
                <div class="tab"><h5 class="tab-heading">Reports</h5></div>
            </router-link>
        </div>
        <div id="tabs-content" style="z-index: 1">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "TabbedView",
        props: {
            model: {},
        }
    }
</script>

<style scoped>
    #account-tabs-floater {
        border-radius: 0px;
    }
    #tabs-content {
        z-index: 1;
        background-color: rgb(229, 245, 255);
    }
    .tabs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        margin: 0 0 -5px 0;
        width: 100%;
        /*padding: 0 0 -3px;*/
        z-index: -1;
    }
    .tab {
        justify-content: center;
        padding:0 8px;
        border-top: 1px solid midnightblue;
        border-left: 1px solid midnightblue;
        border-right: 1px solid midnightblue;
        border-radius: 0px;
        z-index: -1;
    }
    h5.tab-heading {
        padding: 0 0;
        text-align: center;
    }
    router-link {
        background-color: rgba(22, 167, 255, 0.33);
    }
    .router-link-active,
    .router-link-exact-active {
        background-color: #E5F5FF;
    }
</style>
