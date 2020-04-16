<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><slot></slot></h5>
        <h5 v-if="edit" style="width:100%;">
            <ContactInputCombobox style="width:95%" id="input" type="text" :value="text" :account-id="accountId" @contactSelected="contactSelected" width="100%"></ContactInputCombobox>
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
    import ContactInputCombobox from "./ContactInputCombobox";
    export default {
        name: "EditableContactComboboxRow",
        components: {
            ContactInputCombobox,
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            value: null,
            accountId: null,
        },
        data () {
            return {
                text: this.value,
                edit: false,
                selectedContact: {},
            }
        },
        methods: {
            contactSelected (value) {
                this.selectedContact = value;
            },
            cancel () {
                this.edit = !this.edit;
            },
            ok () {
                if (Object.entries(this.selectedContact).length > 0) {
                    // ok not possible with no contact selected
                    this.edit = !this.edit;
                    this.$emit('confirmed', this.selectedContact);
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
