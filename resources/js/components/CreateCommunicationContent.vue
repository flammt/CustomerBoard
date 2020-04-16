<template>
    <div id="communication" style="max-height: 630px">
        <div id="content" class="content-floater">
            <div>
                <FormDateRow :value="date" @change="dateSelected">Datum</FormDateRow>
                <AccountInputComboboxRow :account="account" :placeholder="'Kundenname'" @accountSelected="accountSelected"></AccountInputComboboxRow>
                <ContactInputComboboxRow :selectedAccount="account" :placeholder="'Kundenmitarbeiter'" :contact="contact"
                                         @contactSelected="contactSelected" @input="contactText"></ContactInputComboboxRow>
                <CommunicationTypeOptionRow :items="communicationTypes" @selected="typeSelected">Gesprächsart</CommunicationTypeOptionRow>
                <FormTextAreaRow :value="memo" :lines="lines" @input="textInput">Notitzen</FormTextAreaRow>
                <FormDateRow :value="nextContact" @change="nextContactSelected">Nächster Kontakttermin</FormDateRow>
            </div>
            <div style="display:flex; justify-content: space-between">
                <div style="">
                    <button style="bottom:0;left:0;" class="button green-button" @click="clearForm">Abbrechen</button>
                </div>
                <MessageRow :message="formMessage"></MessageRow>
                <button style="" class="button green-button" @click="saveCommunication">Speichern</button>
            </div>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "./bricks/FormTextRow";
    import FormTextAreaRow from "./bricks/FormTextAreaRow";
    import moment from "moment";
    import FormDateRow from "./bricks/FormDateRow";
    import AccountInputComboboxRow from "./AccountInputComboboxRow";
    import ContactInputComboboxRow from "./ContactInputComboboxRow";
    import CommunicationTypeOptionRow from "./CommunicationTypeOptionRow";
    import MessageRow from "./bricks/MessageRow";
    import ServiceRequest from "../ServiceRequest";
    import DateFormat from "../DateFormat";

    export default {
        name: "Communication",
        components: {
            MessageRow,
            ContactInputComboboxRow,
            AccountInputComboboxRow,
            FormDateRow,
            FormTextAreaRow,
            FormTextRow,
            CommunicationTypeOptionRow,
        },
        props: {
            lines: 10,
        },
        data () {
            return {
                date: moment().format('YYYY-MM-DD'),
                account: {id:-1},
                contact: null,
                type: null,
                memo: '',
                nextContact: moment().add(1, 'year').format('YYYY-MM-DD'),
                selectedType: 0,
                formMessage: '',
                service: new ServiceRequest(),
                communicationTypes: null,
            }
        },
        methods: {
            saveCommunication() {
                if (!this.type) {
                    this.type = this.communicationTypes[0];
                }
                if (this.validateForm()) {
                    const model = {
                        date: this.date,
                        account: this.account,
                        contact: this.contact,
                        type: this.type,
                        memo: this.memo,
                        nextContact: this.nextContact,
                    };
                    this.service.url = "json/communication";
                    this.service.obj = model;
                    this.service.doPost((error, data) => {
                        if (error) {
                            this.formMessage = 'Bericht nicht gespeichert: ' + data;
                        } else {
                            this.formMessage = 'Bericht gespeichert';
                            this.clearForm();
                        }
                    });
                } else {
                    this.formMessage = 'Nicht alle Felder ausgefüllt';
                }
            },
            validateForm() {
                if (!this.date) return false;
                if (!this.account) return false;
                if (!this.contact) return false;
                if (!this.type) return false;
                if (!this.memo) return false;
                return true;
            },
            nextContactSelected(value) {
                this.nextContact = value;
                this.date = value;
            },
            dateSelected(value) {
                this.date = value;
            },
            accountSelected(value) {
                this.account = value;
            },
            contactSelected(value) {
                this.contact = value;
                this.account = value.account;
            },
            contactText(value) {
                this.contact = value;
            },
            typeSelected(value) {
                this.type = value;
            },
            textInput(value) {
                this.memo = value;
            },
            clearForm() {
                this.date = moment(new Date()).format('YYYY-MM-DD');
                this.account = {};
                this.contact = {};
                this.type = null;
                this.memo = '';
                this.selectedType = 0;
            },
        },
        computed: {
            nextContactx: {
                get () {
                    if (this.account) {
                        if (this.account.nextContact) {
                            return DateFormat.getNativeInput(this.account.nextContact);
                        }
                    }
                    return DateFormat.getPlusOneYear();
                },
            },
            modelAccount () {
                return this.account;
            }
        },
        watch: {
            modelAccount () {
            }
        },
        mounted() {
            this.service.url = "json/communication/types";
            this.service.doGet((error, data) => {
                if (error) {
                    console.error('Load CommunicationType failed: ' + data);
                } else {
                    this.communicationTypes = data;
                }
            });
        }
    }
</script>

<style scoped>
</style>
