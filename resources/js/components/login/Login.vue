<template>
    <form id="form" class="content-floater" action="login">
        <div>
            <div class="form-row" ref="x">
                <h5 style="align-self: center"><label for="email">Email</label></h5>
                <h5 style="justify-self: right;width:100%;"><input style="width:100%" id="email" name="email" type="text" :value="model.email" @input="typedEmail($event.target.value)"></h5>
            </div>
            <div class="form-row" ref="x">
                <h5 style="align-self: center"><label for="password">Passwort</label></h5>
                <h5 style="justify-self: right;width:100%;"><input style="width:100%" id="password" name="password" type="password" :value="model.password" @input="typedPassword($event.target.value)"></h5>
            </div>
        </div>
        <div style="text-align: right">
            <button type="submit" class="button green-button" @click="login">Anmelden</button>
        </div>
    </form>
</template>

<script>
    import FormTextRow from "../bricks/FormTextRow";
    export default {
        name: "Login",
        components: {
            FormTextRow,
        },
        data () {
            return {
                model: {
                    email: '',
                    password: '',
                }
            }
        },
        methods: {
            typedEmail (value) {
                this.model.email = value;
            },
            typedPassword (value) {
                this.model.password = value;
            },
            login () {
            }
        }
    }
</script>

<style scoped>
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 0 10px 0 0;
        margin: 5px 0 5px 0;
    }
</style>
