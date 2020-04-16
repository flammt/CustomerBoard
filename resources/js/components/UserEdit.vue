<template>
    <div>
        <EditablePropertyRow :value="model.email" @confirmed="updateEmail">Email</EditablePropertyRow>
        <EditablePropertyRow :value="model.salutation" @confirmed="updateSalutation">Anrede</EditablePropertyRow>
        <EditablePropertyRow :value="model.firstname" @confirmed="updateFirstname">Vorname</EditablePropertyRow>
        <EditablePropertyRow :value="model.lastname" @confirmed="updateLastname">Nachname</EditablePropertyRow>
        <EditablePropertyRow :value="model.name_token" @confirmed="updateMnemonic">Kürzel</EditablePropertyRow>
<!--        <EditablePropertyRow :value="model.password" @confirmed="updatePassword">Passwort</EditablePropertyRow>-->
        <EditableCheckboxRow :value="model.active" @confirmed="updateActive">Aktiv</EditableCheckboxRow>
    </div>
</template>

<script>
    import ServiceRequest from "../ServiceRequest";
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import EditableCheckboxRow from "./bricks/EditableCheckboxRow";

    export default {
        name: "UserEdit",
        components: {
            EditableCheckboxRow,
            EditablePropertyRow,
        },
        props: {
            id: null,
            newUser: false,
        },
        data () {
            return {
                model: {},
                saved: false,
                validation: {
                    email: '',
                    salutation: '',
                    firstname: '',
                    lastname: '',
                    name_token: '',
                },
                inputValid: false,
                formMessage: '',
                service: new ServiceRequest(),
            }
        },
        methods: {
            updateEmail (text) {
                this.model.email = text;
                this.updateUser();
            },
            updateSalutation (text) {
                this.model.salutation = text;
                this.updateUser();
            },
            updateFirstname (text) {
                this.model.firstname = text;
                this.updateUser();
            },
            updateLastname (text) {
                this.model.lastname = text;
                this.updateUser();
            },
            updateMnemonic (text) {
                this.model.mnemonic = text;
                this.updateUser();
            },
            updatePassword (text) {
                this.model.password = text;
                this.updateUser();
            },
            updateActive (tf) {
                this.model.active = tf;
                this.updateUser();
            },
            updateUser () {
                this.service.url = "json/user/"+this.model.id;
                this.service.obj = this.model;
                this.service.doPut((error, data) => {
                    if (error) {
                        this.formMessage = 'Benutzer nicht geändert: '+data;
                    } else {
                        this.formMessage = 'Benutzer geändert';
                    }
                });
            },
            loadUser () {
                this.service.url = "json/user/"+this.id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Loading User failed: ' + data);
                    } else {
                        this.model = data;
                    }
                });
            },
        },
        watch: {
            id () {
                this.loadUser();
            },
        },
        mounted () {
            this.loadUser();
        },
    }
</script>

<style scoped>
    #formWithValidation {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-auto-flow: column;
        grid-column-gap: 10px;
    }
    .row7 {
        grid-template-rows: repeat(8, auto);
    }
    .row8 {
        grid-template-rows: repeat(8, auto);
    }
</style>
