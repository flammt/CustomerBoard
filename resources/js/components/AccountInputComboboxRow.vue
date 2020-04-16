<template>
    <FormInputComboboxRow :items="items" :value="value" :placeholder="placeholder" @input="input" @select="select" @click="click">Kunde</FormInputComboboxRow>
</template>

<script>
    import FormInputComboboxRow from "./bricks/FormInputComboboxRow";
    import ServiceRequest from "../ServiceRequest";
    export default {
        name: "AccountInputComboboxRow",
        components: {
            FormInputComboboxRow
        },
        props: {
            account: {},
            placeholder: '',
        },
        data () {
            return {
                value: '',
                inputText: '',
                accountsFound: [],
                selectedAccount: {},
                cancelSource: null,
                service: new ServiceRequest(),
            }
        },
        methods: {
            click () {
                this.value = '';
                this.selectedAccount = {};
                this.$emit('accountSelected', {});
            },
            select (value) {
                this.selectedAccount = this.accountsFound.find(x => x.id == value.id);
                this.value = value.name;
                this.accountsFound = [];
                this.$emit('accountSelected', this.selectedAccount);
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
                    this.service.url = "json/account/searchName/"+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error(data);
                            this.accountsFound = [];
                        } else {
                            this.accountsFound = data;
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
                this.accountsFound.some(function (account) {
                    if (account.id === value.id) {
                        this.selectedAccount = account;
                        return true;
                    }
                });
            },
        },
        computed: {
            items () {
                const items = [];
                this.accountsFound.forEach(function (account) {
                    items.push({
                        id: account.id,
                        name: account.name,
                    });
                });
                return items;
            }
        },
        watch: {
            account () {
                if (this.account) {
                    this.selectedAccount = this.account;
                    this.value = this.account.name;
                }
            }
        },
    }
</script>

<style scoped>

</style>
