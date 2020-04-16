<template>
    <div style="max-height: 630px">
        <div style="" v-if="model.id">
            <h4 style="margin: 15px 0 10px 0;text-align:right">Neue Adresse</h4>
            <FormTextRow :value="address.name1">Feld 1</FormTextRow>
            <FormTextRow :value="address.name2">Feld 2</FormTextRow>
            <FormTextRow :value="address.name3">Feld 3</FormTextRow>
            <FormTextRow :value="address.street">Straße</FormTextRow>
            <FormTextRow :value="address.countryCode">LKZ</FormTextRow>
            <FormTextRow :value="address.zip">PLZ</FormTextRow>
            <FormTextRow :value="address.town">Stadt</FormTextRow>
            <button style="float: right; " class="button green-button" @click="saveAddress">Speichern</button>
        </div>
    </div>
</template>

<script>
    import EditablePropertyRow from "../bricks/EditablePropertyRow";
    import FormTextRow from "../bricks/FormTextRow";
    import MessageRow from "../bricks/MessageRow";
    import CommunicationTypeOptionRow from "../CommunicationTypeOptionRow";
    import FormTextAreaRow from "../bricks/FormTextAreaRow";
    import axios from "axios";
    import ContactInputComboboxRow from "../ContactInputComboboxRow";

    export default {
        name: "AccountNewSub",
        components: {
            ContactInputComboboxRow,
            EditablePropertyRow,
            FormTextRow,
            MessageRow,
            CommunicationTypeOptionRow,
            FormTextAreaRow,
        },
        props: {
            model: {},
            fromPath: '',
        },
        data () {
            return {
                address: {
                    name1: '',
                    name2: '',
                    name3: '',
                    street: '',
                    countryCode: '',
                    zip: '',
                    town: '',
                },
                formMessage: '',
            }
        },
        methods: {
            saveContact () {
                this.contact.accountId = this.model.id;
                axios.post("json/contact/store", this.contact).then(response => {
                    if (response.data.status.code !== 200) {
                        console.error(response.data.status.message);
                        return;
                    }
                    this.formMessage = response.data.result.data;
                    if (response.data.result.success) {
                        this.$emit('requireReload');
                        this.$router.push('/browseAccounts/account/'+this.model.id);
                    }
                }).catch(error => {
                    console.error('saveAccount: ' + error);
                });
            },
            saveAddress () {

            },
            inputTitle (value) {
                this.contact.title = value;
            },
            inputFirstname (value) {
                this.contact.firstname = value;
            },
            inputLastname (value) {
                this.contact.lastname = value;
            },
            inputGender (value) {
                this.contact.gender = value;
            },
            inputDepartment (value) {
                this.contact.department = value;
            },
            inputPosition (value) {
                this.contact.position = value;
            },
        },
        computed: {
        },
        watch: {
        },
    }
</script>

<style scoped>

</style>
