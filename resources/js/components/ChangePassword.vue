<template>
    <div>
        <h3>Passwort ändern</h3>
        <div id="change-pwd">
            <div class="content-floater">
                <div>
                    <FormTextRow type="text" placeholder="Altes Passwort" :value="model.oldPwd" @input="inputOld">Altes Passwort</FormTextRow>
                    <FormTextRow type="text" placeholder="Neues Passwort" :value="model.newPwd" @input="inputNew">Neues Passwort</FormTextRow>
                    <MessageRow :message="formMessage"></MessageRow>
                </div>
                <div style="display:flex; justify-content: space-between; padding-top:40px">
                    <button class="button green-button" @click="generatePassword">generieren</button>
                    <button style="" class="button green-button" @click="save">Übernehmen</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "./bricks/FormTextRow";
    import ServiceRequest from "../ServiceRequest";
    import MessageRow from "./bricks/MessageRow";

    export default {
        name: "ChangePassword",
        components: {
            MessageRow,
            FormTextRow,
        },
        props: {
        },
        data () {
            return {
                service: new ServiceRequest(),
                formMessage: '',
                model: {
                    oldPwd: '',
                    newPwd: '',
                }
            }
        },
        methods: {
            inputOld (value) {
                this.model.oldPwd = value;
            },
            inputNew (value) {
                this.model.newPwd = value;
            },
            save () {
                this.service.url = "json/user/chpwd";
                this.service.obj = this.model;
                this.service.doPut((error, data) => {
                    if (error) {
                        this.formMessage = 'Passwort nicht geändert: ' + data;
                    } else {
                        this.formMessage = 'Passwort geändert';
                        this.model.oldPwd = '';
                        this.model.newPwd = '';
                    }
                });
            },
            generatePassword () {
                const length = 8,
                    charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!_-/$|#~";
                let retVal = "";
                for (let i = 0, n = charset.length; i < length; ++i) {
                    retVal += charset.charAt(Math.floor(Math.random() * n));
                }
                this.model.newPwd = retVal;
            },
        }
    }
</script>

<style scoped>
    #change-pwd {
        display: grid;
        grid-template-columns: 1fr 3fr;
        grid-gap: 10px;
    }
</style>