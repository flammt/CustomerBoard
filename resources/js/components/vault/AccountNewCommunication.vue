<template>
    <div style="max-height: 630px">
        <div style="" v-if="model.id">
            <h4 style="margin: 15px 0 10px 0;text-align:right">Neuer Besuchsbericht</h4>
            <FormTextRow :value="communication.date">Datum</FormTextRow>
            <ContactInputComboboxRow :selectedAccount="model.account" :contact="communication.contact" @contactSelected="contactSelected"></ContactInputComboboxRow>
            <CommunicationTypeOptionRow :value="communication.type.name">Gesprächsart</CommunicationTypeOptionRow>
            <FormTextAreaRow :value="communication.memo" :lines="10">Notitzen</FormTextAreaRow>
            <button style="float: right; " class="button green-button" @click="saveCommunication">Speichern</button>
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
    import moment from "moment";
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
                communication: {
                    date: moment(new Date()).format('YYYY-MM-DD'),
                    contact: {},
                    user: {},
                    type: {},
                    memo: '',
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
            saveCommunication () {

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
