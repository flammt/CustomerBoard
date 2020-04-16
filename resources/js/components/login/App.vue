<template>
    <div id="app">
        <div id="header" class="section-floater">
            <Header></Header>
        </div>
        <div id="content" class="section-floater">
            <h3>Login</h3>
            <form id="form" class="content-floater" action="login" method="post">
                <input type="hidden" name="_token" :value="csrf">
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
        </div>
        <div id="footer" class="section-floater">
            <span>Your Company</span>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "../bricks/FormTextRow";
    import Header from "./Header";
    export default {
        name: "Login",
        components: {
            Header,
            FormTextRow,
        },
        data () {
            return {
                model: {
                    email: '',
                    password: '',
                },
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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
    div {
        /*border: 1px solid darkred;*/
    }
    #login-app {
        display: grid;
        grid-template-rows: 64px auto 42px;
        grid-gap: 20px;
    }
    #header {
        padding: 10px;
    }
    #content {
        grid-row-start: 2;
        grid-row-end: 3;
        padding: 10px 10px 15px 10px;
    }
    #footer {
        grid-row-start: 3;
        grid-row-end: 4;
        padding: 10px;
     }
    #header>h1 {
        padding: 0 0 0 10px;
        margin: 0;
    }
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        padding: 0 10px 0 0;
        margin: 5px 0 5px 0;
    }
</style>
