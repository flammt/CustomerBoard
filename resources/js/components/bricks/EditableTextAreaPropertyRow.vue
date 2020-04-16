<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><label for="textarea"><slot></slot></label></h5>
        <h5 v-if="edit" style="width:100%;">
            <textarea id="textarea" rows="5" style="width:95%" v-model="text">{{text}}</textarea>
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
        name: "EditableTextAreaPropertyRow",
        components: {
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            value: null,
            lines: 10,
        },
        data () {
            return {
                edit: false,
                text: this.value,
            }
        },
        methods: {
            cancel () {
                this.text = this.value;
                this.switchEdit();
            },
            ok () {
                this.switchEdit();
                this.$emit('confirmed', this.text);
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        computed: {
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
