<template>
    <div>
        <div id="formWithValidation" :class="{row7: model.id, row8: !model.id}">
            <FormTextRow :value="model.email" @change="validateEmail">Email</FormTextRow>
            <FormTextRow :value="model.salutation" @change="validateSalutation">Anrede</FormTextRow>
            <FormTextRow :value="model.firstname" @change="validateFirstname">Vorname</FormTextRow>
            <FormTextRow :value="model.lastname" @change="validateLastname">Nachname</FormTextRow>
            <FormTextRow :value="model.name_token" @change="validateNameToken">Kürzel</FormTextRow>
            <FormTextRow :value="model.password" @change="validatePasswordToken">Passwort</FormTextRow>
            <FormCheckboxRow :checked="model.active" @change="changeActive">Aktiv</FormCheckboxRow>
            <MessageRow :message="formMessage"></MessageRow>
            <FormValidationRow>{{validation.email}}</FormValidationRow>
            <FormValidationRow>{{validation.salutation}}</FormValidationRow>
            <FormValidationRow>{{validation.firstname}}</FormValidationRow>
            <FormValidationRow>{{validation.lastname}}</FormValidationRow>
            <FormValidationRow>{{validation.name_token}}</FormValidationRow>
            <FormValidationRow>{{validation.password}}</FormValidationRow>
        </div>
        <button style="float: right" class="button green-button" @click="saveUser">Speichern</button><button class="button green-button" @click="generatePassword">Passwort generieren</button>
    </div>
</template>

<script>
    import FormTextRow from "./bricks/FormTextRow";
    import FormCheckboxRow from "./bricks/FormCheckboxRow";
    import FormValidationRow from "./bricks/FormValidationRow";
    import MessageRow from "./bricks/MessageRow";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "UserNew",
        components: {
            MessageRow,
            FormTextRow,
            FormCheckboxRow,
            FormValidationRow,
        },
        props: {
            id: null,
            user: {},
        },
        data () {
            return {
                model: {
                    id: 0,
                    email: '',
                    salutation: '',
                    firstname: '',
                    lastname: '',
                    name_token: '',
                    password: '',
                    active: true,
                },
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
            validateEmail (event) {
                this.model.email = event;
                if(event.length === 0) {
                    this.validation.email = "Email ist erforderlich";
                } else {
                    this.validation.email = '';
                }
            },
            validateSalutation (event) {
                this.model.salutation = event;
                if(this.model.salutation.length === 0) {
                    this.validation.salutation = "Anrede ist erforderlich";
                } else {
                    this.validation.salutation = '';
                }
            },
            validateFirstname (event) {
                this.model.firstname = event;
                if(this.model.firstname.length === 0) {
                    this.validation.firstname = "Vorname ist erforderlich";
                } else {
                    this.validation.firstname = '';
                }
            },
            validateLastname (event) {
                this.model.lastname = event;
                if(this.model.lastname.length === 0) {
                    this.validation.lastname = "Nachname ist erforderlich";
                } else {
                    this.validation.lastname = '';
                }
            },
            validateNameToken (event) {
                this.model.name_token = event;
                if(this.model.name_token.length === 0) {
                    this.validation.name_token = "Kürzel ist erforderlich";
                } else {
                    this.validation.name_token = '';
                }
            },
            validatePasswordToken (event) {
                this.model.password = event;
                if(event.length === 0) {
                    this.validation.password = "Passwort ist erforderlich";
                } else {
                    this.validation.password = '';
                }
            },
            changeActive (event) {
                this.model.active = event;
            },
            generatePassword () {
                const length = 8,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!_-/$|#~";
                let retVal = "";
                for (let i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                this.model.password = retVal;
            },
            saveUser () {
                this.service.url = "json/user";
                this.service.obj = this.model;
                this.service.doPost((error, data) => {
                    if (error) {
                        this.formMessage = 'Benutzer nicht gespeichert: '+data;
                    } else {
                        this.formMessage = 'Benutzer gespeichert';
                        this.$router.push('/manageUsers/user/'+data);
                    }

                });
            },
        },
        updated() {
        },
        watch: {
        },
        mounted () {
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
