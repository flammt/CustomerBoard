<template>
    <div id="property-row" class="form-row">
        <h5><slot></slot></h5>
        <h5 v-if="edit" style="width:100%;">
            <UserInputCombobox style="width:95%" id="input" type="text" :value="text" @userSelected="userSelected"></UserInputCombobox>
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
    import CancelButton from "./bricks/CancelButton";
    import OkButton from "./bricks/OkButton";
    import EditButton from "./bricks/EditButton";
    import UserInputCombobox from "./UserInputCombobox";
    export default {
        name: "EditablePropertyRow",
        components: {
            UserInputCombobox,
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
                edit: false,
                selectedUser: {},
            }
        },
        methods: {
            userSelected (value) {
                this.selectedUser = value;
            },
            cancel () {
                this.switchEdit();
            },
            ok () {
                if (Object.entries(this.selectedUser).length > 0) {
                    // ok not possible with no user selected
                    this.switchEdit();
                    this.$emit('confirmed', this.selectedUser);
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

<style scoped>
    #property-row {
        display: grid;
        grid-template-columns: 7fr 13fr 3fr;
        padding: 0 10px 0 0;
        margin: 5px 0 5px 0;
        align-items: center;
    }
</style>
