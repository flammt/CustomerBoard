<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><label for="input"><slot></slot></label></h5>
        <h5 v-if="edit" style="width:100%;">
            <input style="width:95%" id="input" type="text" v-model="text" @keypress="keypress($event.keyCode)">
        </h5>
        <h5 v-else style="width:100%;">{{text}}</h5>
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
    import CancelButton from "./CancelButton";
    import OkButton from "./OkButton";
    import EditButton from "./EditButton";
    export default {
        name: "EditablePropertyRow",
        components: {
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            value: null,
        },
        data () {
            return {
                text: this.value,
                edit: false
            }
        },
        methods: {
            keypress (code) {
                // accept enter to complete
                if (code === 13) {
                    this.ok();
                }
            },
            cancel () {
                this.text = this.value;
                this.switchEdit();
            },
            ok () {
                if (this.text != this.value) {
                    // only confirm changed value
                    this.switchEdit();
                    this.$emit('confirmed', this.text);
                }
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        watch: {
            value () {
                this.text = this.value;
            }
        }
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
