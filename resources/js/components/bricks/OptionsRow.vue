<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><label for="name"><slot></slot></label></h5>
        <h5 style="width:100%;">
            <h5 style="justify-self: right;width:100%;">
                <select id="name" @change="changed($event.target.value)">
                    <option v-for="item in items" :key="item.id" :value="item.id">{{item.name}}</option>
                </select>
            </h5>
        </h5>
    </div>
</template>

<script>
    export default {
        name: "OptionsRow",
        components: {
        },
        props: {
            items: {},
            value: {
                id: 0,
                name: '',
            },
        },
        data () {
            return {
                selected: this.value,
                // selectedId: this.value.id,
            }
        },
        methods: {
            changed (value) {
                this.selected = this.items[value-1];
                this.$emit('change', this.selected);
            }
        },
        mounted () {
            this.$emit('change', this.selected);
        },
        watch: {
        }
    }
</script>

<style lang="sass" scoped>
    #property-row
        display: grid
        grid-template-columns: 7fr 13fr 3fr
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
</style>