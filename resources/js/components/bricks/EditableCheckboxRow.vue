<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><slot></slot></h5>
        <h5 v-if="edit" style="width:100%;">
            <input style="text-align: left" type="checkbox" :checked="checked" @change="checked = !checked">
        </h5>
        <h5 v-else style="width:100%;">
            <input style="text-align: left" type="checkbox" :checked="checked" disabled>
        </h5>
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
        name: "EditableCheckboxRow",
        components: {
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            value: false
        },
        data () {
            return {
                checked: false,
                edit: false
            }
        },
        methods: {
            cancel () {
                this.checked = this.value;
                this.switchEdit();
            },
            ok () {
                if (this.checked != this.value) {
                    // confirm only possible when state has changed
                    this.switchEdit();
                    this.$emit('confirmed', this.checked);
                }
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        watch: {
            value () {
                this.checked = this.value
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
</style>
