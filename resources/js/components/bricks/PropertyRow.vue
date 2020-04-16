<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: start"><slot></slot></h5>
        <h5 style="justify-self: start;width:100%;">{{value}}</h5>
    </div>
</template>

<script>
    export default {
        name: "PropertyRow",
        props: {
            value: ''
        },
    }
</script>

<style lang="sass" scoped>
    #property-row
        display: grid
        grid-template-columns: 7fr 16fr
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
</style>
