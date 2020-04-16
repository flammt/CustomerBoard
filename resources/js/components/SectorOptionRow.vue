<template>
    <div id="form-row" class="form-row">
        <h5 style="align-self: center"><label for="name"><slot></slot></label></h5>
        <h5 style="justify-self: right;width:100%;">
            <select id="name" :value="selectedId" @change="changed($event.target.value)">
                <option v-for="sector in items" :key="sector.id" :value="sector.id">{{sector.name}}</option>
            </select>
        </h5>
    </div>
</template>

<script>

    export default {
        name: "SectorOptionRow",
        props: {
            value: null,
            items: Array,
        },
        data () {
            return {
                selected: null,
                selectedId: null,
            }
        },
        mounted() {
        },
        methods: {
            changed (value) {
                this.$emit('selected', value);
            }
        },
        watch: {
            value () {
                this.selected = this.value;
                this.selectedId = this.selected.id;
            }
        }
    }
</script>

<style scoped>
    #form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 0 10px 0 0;
        margin: 5px 0 5px 0;
    }
</style>
