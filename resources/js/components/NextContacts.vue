<template>
    <div>
        <h3>Kontakte</h3>
        <div id="next-contacts">
            <div id="search" class="content-floater">
                <div>
                    <TextRow>Kundenmanager</TextRow>
                    <UserInputCombobox :placeholder="accountManagerName" @userSelected="userSelected"></UserInputCombobox>
                    <div style="padding:5px"></div>
                    <TextRow>Termine bis</TextRow>
                    <input style="width:100%" type="date" :value="dateUntil" @change="dateUntilChanged($event.target.value)">
                    <div style="padding:5px"></div>
                    <TextRow>Kundenmanager</TextRow>
                    <input id="allUsers" type="checkbox" @change="selectAllUsers($event.target.checked)">
                    <label for="allUsers">Alle</label>
                    <div style="padding:5px"></div>
                    <TextRow>Anzeige</TextRow>
                    <input id="openContacts" type="checkbox" :checked="openContacts" @change="selectOpenContacts($event.target.checked)">
                    <label for="openContacts">Offene Kontakte</label>
                    <div style="padding:5px"></div>
                    <input id="doneContacts" type="checkbox" :checked="!openContacts" @change="selectDoneContacts($event.target.checked)">
                    <label for="doneContacts">Erledigte Kontakte</label>
                    <div style="padding:8px"></div>
                    <TextRow>Seiten</TextRow>
                    <Paginator :data="accounts" :page="currentPage" @backward="backward" @forward="forward"></Paginator>
                </div>
            </div>
            <router-view :accounts="accounts" :height="height" @dateChanged="nextContactDateChanged($event)"></router-view>
        </div>
    </div>
</template>

<script>
    import UserInputCombobox from "./UserInputCombobox";
    import moment from "moment";
    import TextRow from "./bricks/TextRow";
    import NextContact from "./NextContact";
    import ServiceRequest from "../ServiceRequest";
    import DateFormat from "../DateFormat";
    import Utils from "../Utils";
    import Paginator from "./bricks/Paginator";
    import FormCheckboxRow from "./bricks/FormCheckboxRow";

    export default {
        name: "NextContacts",
        components: {
            FormCheckboxRow,
            Paginator,
            NextContact,
            TextRow,
            UserInputCombobox
        },
        props: {
            height: null
        },
        data () {
            return {
                accountManager: {},
                dateUntil: DateFormat.getNativeInput(moment().subtract(1, 'week')),
                accounts: null,
                service: new ServiceRequest(),
                allUsers: false,
                openContacts: true,
                currentPage: null,
            }
        },
        methods: {
            backward (page) {
                this.currentPage = page
                this.$router.push('/nextContacts/'+page)
            },
            forward (page) {
                this.currentPage = page
                this.$router.push('/nextContacts/'+page)
            },
            nextContactDateChanged (account) {
                this.service.url = "json/account/"+account.id;
                this.service.obj = account;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.load();
                    }
                });
            },
            dateUntilChanged (value) {
                this.dateUntil = value;
                this.load();
            },
            selectAllUsers (value) {
                this.allUsers = value;
                this.load();
            },
            selectOpenContacts (value) {
                this.openContacts = value;
                this.load();
            },
            selectDoneContacts (value) {
                this.openContacts = !value;
                this.load();
            },
            userSelected (user) {
                this.accountManager = user;
                if(this.accountManager.id) {
                    this.load();
                }
            },
            load () {
                const userId = this.allUsers ? '' : this.accountManager.id;
                this.service.url = "json/account/nextContacts/"+this.dateUntil+'/'+this.openContacts+'/'+userId;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Loading Next Contacts failed: ' + data);
                    } else {
                        this.accounts = data;
                    }
                });
                this.currentPage = 1
                this.$router.push('/nextContacts/'+1).catch(err => {})
            },
            authUser () {
                this.service.url = "json/user/auth";
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Loading User failed: ' + data);
                    } else {
                        this.accountManager = data;
                        this.load();
                    }
                });
            }
        },
        computed: {
            accountManagerName () {
                // if (this.accountManager && (this.accountManager.firstname || this.accountManager.lastname)) {
                //     return this.accountManager.firstname +' ' +this.accountManager.lastname
                // }
                return Utils.notEmptyConcatReplace([this.accountManager.firstname, ' ', this.accountManager.lastname], ['[Vorname]', ' ', '[Name]'])
            }
        },
        mounted() {
            this.authUser();
        }
    }
</script>

<style scoped>
    label {
        color: #fffef6;
    }
    #next-contacts {
        display: grid;
        grid-template-columns: 1fr 5fr;
        grid-gap: 10px;
    }
    #search {
        display: grid;
        grid-template-rows: auto auto;
    }
</style>
