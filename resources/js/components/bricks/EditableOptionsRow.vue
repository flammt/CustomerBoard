<template>
    <div id="property-row" class="form-row">
        <h5><label for="select"><slot></slot></label></h5>
        <h5 v-if="edit" style="width:100%;align-items: center">
            <select id="select" v-model="selectedId" @change="changed($event.target.value)">
                <option v-for="item in items" :key="item.id" :value="item.id">{{item.name}}</option>
            </select>
        </h5>
        <h5 v-else style="width:100%;">{{selected.name}}</h5>
        <div style="justify-self: right">
            <div v-if="edit" style="display: flex; justify-content: right">
                <OkButton @click="ok"></OkButton>
                <CancelButton @click="cancel"></CancelButton>
            </div>
            <EditButton v-else @click="switchEdit" style="justify-self: right"></EditButton>
        </div>
    </div>
</template>

<script>
    import OkButton from "./OkButton";
    import CancelButton from "./CancelButton";
    import EditButton from "./EditButton";
    export default {
        name: "EditableOptionsRow",
        components: {
            OkButton,
            CancelButton,
            EditButton,
        },
        props: {
            items: null,
            value: null,
        },
        data () {
            return {
                edit: false,
                selected: this.value,
                selectedId: this.value.id,
            }
        },
        methods: {
            cancel () {
                this.selected = this.value;
                this.selectedId = this.selected.id;
                this.edit = !this.edit;
            },
            ok () {
                this.switchEdit();
                this.$emit('confirmed', this.selected);
            },
            switchEdit () {
                this.edit = !this.edit;
            },
            changed (value) {
                this.selected = this.items.find(x => x.id == value);
                this.selectedId = this.selected.id;
                this.$emit('change', this.selected);
            }
        },
    }
</script>

<style lang="sass" scoped>
    #property-row
        display: grid
        grid-template-columns: 7fr 13fr 3fr
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
        align-items: center
</style>