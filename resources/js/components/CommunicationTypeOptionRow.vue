<template>
    <div id="form-row" class="form-row">
        <h5 style="align-self: center"><label for="name"><slot></slot></label></h5>
        <h5 style="justify-self: right;width:100%;">
            <select id="name" @change="changed($event.target.value)">
                <option v-for="type in items" :key="type.id" :value="type.id">{{type.name}}</option>
            </select>
        </h5>
    </div>
</template>

<script>

    export default {
        name: "CommunicationTypeOptionRow",
        props: {
            value: '',
            selected: 0,
            items: Array,
        },
        data () {
            return {
            }
        },
        mounted() {
        },
        methods: {
            changed (value) {
                const selected = this.items.find(x => x.id == value);
                this.$emit('selected', selected);
            }
        },
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
