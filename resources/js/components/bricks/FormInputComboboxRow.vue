<template>
    <div id="form-row" class="form-row">
        <h5>
            <label for="input"><slot></slot></label>
        </h5>
        <div class="searchContainer">
            <input id="input" type="text" :placeholder="placeholder" style="padding: 2px 0 2px 0;margin: 5px 0 5px 0;width:100%;justify-self: right" :value="value" @click="$emit('click')" @input="input($event.target.value)">
            <div class="searchFloat" v-if="floaterOn">
                <div class="foundList" style="padding-bottom: 5px">
                    <h5 class="hl" v-for="item in items" :key="item.id" @click="$emit('select', item)">{{item.name}}</h5>
                </div>
                <h5 class="hl" style="border:1px solid black;color:red;" @click="floaterOn = false">x</h5>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "FormImputComboboxRow",
        components: {
        },
        props: {
            value: '',
            items: Array,
            placeholder: '',
        },
        data () {
            return {
                floaterOn: false,
            }
        },
        methods: {
            input (value) {
                this.inputText = value;
                this.$emit('input', value)
            },
        },
        watch: {
            items: function() {
                this.floaterOn = this.items.length !== 0;
            }
        }
    }
</script>

<style lang="sass" scoped>
    #form-row 
        display: grid
        grid-template-columns: 1fr 1fr
        padding: 0 5px 0 0
        margin: 5px 0 5px 0
        align-items: center
    
    .searchContainer
        position: relative
    
    .searchFloat 
        background-color: rgb(255, 255, 255)
        display: grid
        grid-template-columns: 18fr 1fr
        position: absolute
        z-index: 255
        width: 100%
    
    .foundList 
        display: grid
        grid-template-columns: 1fr 1fr 1fr
        width: 100%
        border: 1px solid black
    
    .hl
        cursor: pointer
    
    .hl:hover
        cursor: pointer
        background-color: #e9c062 //theme.$sand-orange
    
</style>
