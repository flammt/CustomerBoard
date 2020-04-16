<template>
    <div id="account-part">
        <div id="left" class="content-floater" style="display:flex; flex-direction: column; justify-content: space-between">
            <div id="account">
                <FormTextRow :value="model.name" @input="nameInput">Name</FormTextRow>
                <FormTextRow :value="model.mnemonic" @input="mnemonicInput">Kürzel</FormTextRow>
                <UserInputComboboxRow :value="model.accountManager" @userSelected="userSelected">Kundenbetreuer</UserInputComboboxRow>
                <AccountLevelOptionRow :items="accountLevels" :value="model.level" @selected="levelSelected">Level</AccountLevelOptionRow>
                <SectorOptionRow :value="model.sector" :items="sectors" @selected="sectorSelected">Branche</SectorOptionRow>
                <FormCheckboxRow :value="model.verbotskunde" @change="verbotskundeChanged">Verbotskunde</FormCheckboxRow>
                <MessageRow :message="formMessage"></MessageRow>
            </div>
            <button style="float: right; " class="button green-button" @click="saveAccount">Speichern</button>
        </div>
        <div id="right" class="content-floater" style="max-height:660px">
            <FormTextRow :value="model.address.name1" @input="name1Input">Feld 1</FormTextRow>
            <FormTextRow :value="model.address.name2" @input="name2Input">Feld 2</FormTextRow>
            <FormTextRow :value="model.address.name3" @input="name3Input">Feld 3</FormTextRow>
            <FormTextRow :value="model.address.street" @input="streetInput">Straße</FormTextRow>
            <FormTextRow :value="model.address.countryCode" @input="countryCodeInput">LKZ</FormTextRow>
            <FormTextRow :value="model.address.zip" @input="zipInput">PLZ</FormTextRow>
            <FormTextRow :value="model.address.town" @input="townInput">Stadt</FormTextRow>
        </div>
    </div>
</template>

<script>
    import TextRow from "./bricks/TextRow";
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import axios from "axios";
    import FormTextRow from "./bricks/FormTextRow";
    import FormCheckboxRow from "./bricks/FormCheckboxRow";
    import MessageRow from "./bricks/MessageRow";
    import UserInputComboboxRow from "./UserInputComboboxRow";
    import AccountLevelOptionRow from "./AccountLevelOptionRow";
    import ServiceRequest from "../ServiceRequest";
    import SectorOptionRow from "./SectorOptionRow";

    export default {
        name: "AccountNew",
        components: {
            SectorOptionRow,
            AccountLevelOptionRow,
            UserInputComboboxRow,
            FormCheckboxRow,
            FormTextRow,
            EditablePropertyRow,
            TextRow,
            MessageRow,
        },
        props: {
        },
        data () {
            return {
                model: {
                    name: '',
                    mnemonic: '',
                    accountManager: {},
                    level: {
                        id: 0,
                        description: ''
                    },
                    sector: {
                        id: 0,
                        name: ''
                    },
                    verbotskunde: false,
                    address: {},
                },
                formMessage: '',
                service: new ServiceRequest(),
                accountLevels: [],
                sectors: [],
            }
        },
        computed: {
        },
        methods: {
            saveAccount () {
                this.model.level = this.accountLevels.find(x => x.id == this.model.level.id);;
                this.service.url = "json/account";
                this.service.obj = this.model;
                this.service.doPost((error, data) => {
                    if (error) {
                        this.formMessage = 'Kunde nicht gespeichert: '+data;
                    } else {
                        this.formMessage = 'Kunde gespeichert';
                    }
                });
            },
            userSelected (value) {
                this.model.accountManager = value;
            },
            nameInput (value) {
                this.model.name = value;
            },
            mnemonicInput (value) {
                this.model.mnemonic = value;
            },
            levelSelected (value) {
                this.model.level = this.accountLevels.find(x => x.id == value);
            },
            sectorSelected (value) {
                this.model.sector = this.sectors.find(x => x.id == value);
            },
            verbotskundeChanged (value) {
                this.model.verbotskunde = value;
            },
            name1Input (value) {
                this.model.address.name1 = value;
            },
            name2Input (value) {
                this.model.address.name2 = value;
            },
            name3Input (value) {
                this.model.address.name3 = value;
            },
            streetInput (value) {
                this.model.address.street = value;
            },
            countryCodeInput (value) {
                this.model.address.countryCode = value;
            },
            zipInput (value) {
                this.model.address.zip = value;
            },
            townInput (value) {
                this.model.address.town = value;
            }
        },
        watch: {
        },
        mounted () {
            this.service.url = "json/account/levels";
            this.service.doGet((error, data) => {
                if (error) {
                } else {
                    this.accountLevels = data;
                    this.model.level = this.accountLevels[0]
                }
            });
            this.service.url = "json/account/sectors";
            this.service.doGet((error, data) => {
                if (error) {
                } else {
                    this.sectors = data;
                    this.model.sector = this.sectors[0]
                }
            });
        },

    }
</script>

<style scoped>
    #account-part {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
    }
</style>
