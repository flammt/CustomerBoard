<template>
    <div style="max-height: 630px">
        <div style="" v-if="model.id">
            <h4 style="margin: 15px 0 10px 0;text-align:right">Neuer Kontakt</h4>
            <FormTextRow :value="contact.title" @input="inputTitle">Titel</FormTextRow>
            <FormTextRow :value="contact.firstname" @input="inputFirstname">Vorname</FormTextRow>
            <FormTextRow :value="contact.lastname" @input="inputLastname">Nachname</FormTextRow>
            <FormTextRow :value="contact.gender" @input="inputGender">Gender</FormTextRow>
            <FormTextRow :value="contact.department" @input="inputDepartment">Abteilung</FormTextRow>
            <FormTextRow :value="contact.position" @input="inputPosition">Position</FormTextRow>
            <MessageRow :message="formMessage"></MessageRow>
            <button style="float: right; " class="button green-button" @click="saveContact">Speichern</button>
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
                contact: {
                    titel: '',
                    firstname: '',
                    lastname: '',
                    gender: '',
                    department: '',
                    position: '',
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
