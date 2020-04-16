<template>
    <FormInputComboboxRow :items="items" :value="value" @input="input" @select="select" @click="click"><slot></slot></FormInputComboboxRow>
</template>

<script>
    import FormInputComboboxRow from "./bricks/FormInputComboboxRow";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "UserInputComboboxRow",
        components: {
            FormInputComboboxRow
        },
        props: {
            user: {},
        },
        data () {
            return {
                value: '',
                inputText: '',
                usersFound: [],
                selectedUser: {},
                cancelSource: null,
                service: new ServiceRequest(),
            }
        },
        methods: {
            click () {
                this.value = '';
                this.selectedUser = {};
                this.$emit('userSelected', {});
            },
            select (value) {
                this.selectedUser = this.usersFound.find(x => x.id == value.id);
                this.value = value.name;
                this.usersFound = [];
                this.$emit('userSelected', this.selectedUser);
            },
            input (value) {
                this.inputText = value;
                this.value = value;
                this.searchRequest();
            },
            searchRequest () {
                const currentInput = this.inputText;
                if(currentInput.length > 2) {
                    this.service.cancel();
                    this.service.url = "json/user/searchName/"+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Searching User failed: ' + data);
                            this.usersFound = [];
                        } else {
                            this.usersFound = data;
                        }
                    });
                }
            },
            cancelSearch () {
                if (this.cancelSource) {
                    this.cancelSource.cancel();
                }
            },
            selectAccount (value) {
                this.usersFound.some(function (account) {
                    if (account.id === value.id) {
                        this.selectedUser = account;
                        return true;
                    }
                });
            },
        },
        computed: {
            items () {
                const items = [];
                this.usersFound.forEach(function (user) {
                    items.push({
                        id: user.id,
                        get name() {
                            if(user.firstname) {
                                return user.firstname +' ' +user.lastname;
                            }
                            return user.lastname;
                        }
                    });
                });
                return items;
            }
        },
        watch: {
            account () {
                if (this.user) {
                    this.selectedUser = this.user;
                    this.value = this.user.name;
                }
            }
        },
    }
</script>

<style scoped>

</style>
