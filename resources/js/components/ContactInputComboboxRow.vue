<template>
    <FormInputComboboxRow :items="items" :value="value" :placeholder="placeholder" @input="input" @select="select" @click="click">Gesprächspartner</FormInputComboboxRow>
</template>

<script>
    import FormInputComboboxRow from "./bricks/FormInputComboboxRow";
    import axios from "axios";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "ContactInputComboboxRow",
        components: {
            FormInputComboboxRow
        },
        props: {
            selectedAccount: {},
            contact: {},
            placeholder: '',
            noTemporary: false,
        },
        data () {
            return {
                value: '',
                inputText: '',
                contactsFound: [],
                selectedContact: {},
                cancelSource: null,
                service: new ServiceRequest(),
            }
        },
        methods: {
            click () {
                this.value = '';
                this.service.cancel();
                // quick solution for account->new communication->contact to avoid bigger rebuild
                if (this.noTemporary) {
                    this.service.url = "json/contact/searchInAccountWithout/"+this.selectedAccount.id;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading from all Contacts failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                    return;
                }
                if (Object.entries(this.selectedAccount).length > 0) { // object not empty?
                    this.service.url = "json/contact/allInAccount/"+this.selectedAccount.id;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading Account related Contacts failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                } else {
                    this.service.url = "json/contact/searchAll/";
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading from all Contacts failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                }
            },
            select (value) {
                this.selectedContact = this.contactsFound.find(x => x.id === value.id);
                this.value = value.name;
                this.contactsFound = [];
                this.$emit('contactSelected', this.selectedContact);
            },
            input (value) {
                this.inputText = value;
                this.value = value;
                this.$emit('input', value);
                this.searchRequest();
            },
            searchRequest () {
                const currentInput = this.inputText;
                this.service.cancel();
                // quick solution for account->new communication->contact to avoid bigger rebuild
                if (this.noTemporary) {
                    this.service.url = "json/contact/searchInAccountWithout/"+this.selectedAccount.id+'/'+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading from all Contacts failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                    return;
                }
                if (Object.entries(this.selectedAccount).length > 0) {
                    this.service.url = "json/contact/searchInAccount/"+this.selectedAccount.id+"/"+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading Contacts from Account failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                } else {
                    this.service.url = "json/contact/searchAll/"+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading from all Contacts failed: ' + data);
                            this.contactsFound = [];
                        } else {
                            this.contactsFound = data;
                        }
                    });
                }
            },
            selectContact (value) {
                this.contactsFound.some(function (contact) {
                    if (contact.id === value.id) {
                        this.selectedContact = contact;
                        return true;
                    }
                });
            },
        },
        computed: {
            items () {
                const items = [];
                this.contactsFound.forEach(function (contact) {
                    items.push({
                        id: contact.id,
                        name: contact.lastname,
                    });
                });
                return items;
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>