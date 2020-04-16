<template>
    <div style="max-height: 630px">
        <div style="" v-if="model.id">
            <div v-if="sub === 'contacts'">
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
            <div v-if="sub === 'addresses'">
                <h4 style="margin: 15px 0 10px 0;text-align:right">Neue Adresse</h4>
                <FormTextRow :value="address.name1" @input="inputName1">Feld 1</FormTextRow>
                <FormTextRow :value="address.name2" @input="inputName2">Feld 2</FormTextRow>
                <FormTextRow :value="address.name3" @input="inputName3">Feld 3</FormTextRow>
                <FormTextRow :value="address.street" @input="inputStreet">Straße</FormTextRow>
                <FormTextRow :value="address.countryCode" @input="inputCountryCode">LKZ</FormTextRow>
                <FormTextRow :value="address.zip" @input="inputZip">PLZ</FormTextRow>
                <FormTextRow :value="address.town" @input="inputTown">Stadt</FormTextRow>
                <OptionsRow :items="addressTypes" @change="addressTypeSelected">Typ</OptionsRow>
                <MessageRow :message="formMessage"></MessageRow>
                <button style="float: right; " class="button green-button" @click="saveAddress">Speichern</button>
            </div>
            <div v-if="sub === 'communications'">
                <h4 style="margin: 15px 0 10px 0;text-align:right">Neuer Besuchsbericht</h4>
                <FormDateRow :value="communication.date" @change="dateSelected">Datum</FormDateRow>
                <ContactInputComboboxRow :noTemporary="true" :selectedAccount="model" :contact="communication.contact" @contactSelected="contactSelected" @input="contactInput"></ContactInputComboboxRow>
                <CommunicationTypeOptionRow :items="communicationTypes" @selected="communicationTypeSelected">Gesprächsart</CommunicationTypeOptionRow>
                <FormTextAreaRow :value="communication.memo" :lines="10" @input="textInput">Notitzen</FormTextAreaRow>
                <button style="float: right; " class="button green-button" @click="saveCommunication">Speichern</button>
                <MessageRow :message="formMessage" ></MessageRow>
            </div>
        </div>
    </div>
</template>

<script>
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import FormTextRow from "./bricks/FormTextRow";
    import MessageRow from "./bricks/MessageRow";
    import CommunicationTypeOptionRow from "./CommunicationTypeOptionRow";
    import FormTextAreaRow from "./bricks/FormTextAreaRow";
    import ContactInputComboboxRow from "./ContactInputComboboxRow";
    import FormDateRow from "./bricks/FormDateRow";
    import OptionsRow from "./bricks/OptionsRow";
    import moment from "moment";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "AccountNewSub",
        components: {
            OptionsRow,
            FormDateRow,
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
            sub: '',
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
                address: {
                    name1: '',
                    name2: '',
                    name3: '',
                    street: '',
                    countryCode: '',
                    zip: '',
                    town: '',
                    type: null,
                },
                communication: {
                    date: moment(new Date()).format('YYYY-MM-DD'),
                    contact: {},
                    user: {},
                    type: null,
                    memo: '',
                },
                formMessage: '',
                target: '',
                selectedCommunicationType: 0,
                addressTypes: {},
                service: new ServiceRequest(),
                communicationTypes: [],
            }
        },
        methods: {
            saveContact () {
                this.contact.accountId = this.model.id;
                this.service.url = "json/contact/store";
                this.service.obj = this.contact;
                this.service.doPost((error, data) => {
                    if (error) {
                        this.formMessage = 'Kontakt nicht gespeichert: '+data;
                    } else {
                        this.$router.push('/browseAccounts/account/'+this.model.id+'/contacts');
                    }
                });
            },
            //not in use
            saveAddress () {
                if (!this.address.type) {
                    this.address.type = this.addressTypes[1];
                }
                this.address.accountId = this.model.id;
                this.service.url = "json/address";
                this.service.obj = this.address;
                this.service.doPost((error, data) => {
                    if (error) {
                        this.formMessage = 'Adresse nicht gespeichert: '+data;
                    } else {
                        this.$router.push('/browseAccounts/account/'+this.model.id+'/addresses');
                    }
                });
            },
            saveCommunication () {
                this.communication.account = {
                    id: this.model.id,
                };
                if (!this.communication.type) {
                    this.communication.type = this.communicationTypes[0];
                }
                this.service.url = "json/communication";
                this.service.obj = this.communication;
                this.service.doPost((error, data) => {
                    if (error) {
                        this.formMessage = 'Bericht nicht gespeichert: '+data;
                    } else {
                        this.$router.push('/browseAccounts/account/'+this.model.id+'/communications');
                    }
                });
            },
            loadAddressTypes () {
                this.service.url = "json/address/types";
                this.service.doGet((error, data) => {
                    if (error) {
                    } else {
                        this.addressTypes = data;
                    }
                });
            },
            loadCommunicationTypes () {
                this.service.url = "json/communication/types";
                this.service.doGet((error, data) => {
                    if (error) {
                    } else {
                        this.communicationTypes = data;
                    }
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
            inputName1 (value) {
                this.address.name1 = value;
            },
            inputName2 (value) {
                this.address.name2 = value;
            },
            inputName3 (value) {
                this.address.name3 = value;
            },
            inputStreet (value) {
                this.address.street = value;
            },
            inputCountryCode (value) {
                this.address.countryCode = value;
            },
            inputZip (value) {
                this.address.zip = value;
            },
            inputTown (value) {
                this.address.town = value;
            },

            dateSelected (value) {
                this.communication.date = value;
            },
            contactSelected (value) {
                this.communication.contact = value;
            },
            contactInput (value) {
                this.communication.contact = value
            },
            communicationTypeSelected (value) {
                this.communication.type = value;
            },
            addressTypeSelected (value) {
                this.address.type = value;
            },
            textInput (value) {
                this.communication.memo = value;
            },
        },
        computed: {
        },
        mounted () {
            this.loadAddressTypes();
            this.loadCommunicationTypes();
        },
        watch: {
            model: function () {
            },
            /**
             * Global $route variable. Set in AccountAddresses/Contacts/Communications when route changes.
             * Then we know which was the last active tab.
             * @param to
             * @param from
             */
            $route (to, from) {
                this.target = from.name;
            },
        },
    }
</script>

<style lang="sass" scoped>
    h4
        color: #e9c062 //theme.$sand-orange
</style>
