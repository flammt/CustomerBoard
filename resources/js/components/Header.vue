<template>
    <div id="header-row">
        <div>
            <h3 style="margin: 0 0 0;text-align: left;padding:0">Kunden Besuchsdatenbank</h3>
        </div>
        <div style="display:grid;align-items: start">
            <h5 style="text-align: right"><a href="logout">Logout</a></h5>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Header"
    }
</script>

<style lang="sass" scoped>
    #header-row
        display: grid
        grid-template-columns: 1fr 1fr
        padding: 0 0px 0 0
        margin: 0px 0 0px 0

    h1
        padding: 0 0 0 0px
        margin: 0

</style>
