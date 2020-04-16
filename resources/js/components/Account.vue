<template>
    <div class="account" v-if="id">
        <div class="content-floater" :style="'max-height: '+height+'px'">
            <div class="panel">
                <div style="display:flex;justify-content: space-between">
                    <PanelHeader>Kundendaten</PanelHeader>
                </div>
                <EditablePropertyRow :value="model.name" @confirmed="updateName">Name</EditablePropertyRow>
                <EditablePropertyRow :value="model.mnemonic" @confirmed="updateMnemonic">Kürzel</EditablePropertyRow>
                <EditableUserComboboxRow :value="accountManagerName" @confirmed="updateUser">Kundenbetreuer</EditableUserComboboxRow>
                <EditableAccountLevelOptionRow :items="levels" :value="model.level" @confirmed="updateLevel">Level</EditableAccountLevelOptionRow>
                <EditableCheckboxRow :value="model.verbotskunde" @confirmed="updateVerbotskunde">Verbotskunde</EditableCheckboxRow>
                <EditableSectorOptionRow :items="sectors" :value="model.sector" @confirmed="updateSector">Branche</EditableSectorOptionRow>
                <EditableDateRow :value="model.nextContact" @confirmed="updateNextContact">Kontakttermin</EditableDateRow>
                <div class="inside-panel" v-if="model.address">
                    <div style="display:flex;justify-content: space-between">
                        <PanelHeader>Hauptadresse</PanelHeader>
                    </div>
                    <PropertyRow :value="accountAddressName"></PropertyRow>
                    <PropertyRow :value="accountAddressStreet"></PropertyRow>
                    <PropertyRow :value="accountAddressTown"></PropertyRow>
                    <PropertyRow v-for="connection in model.address.connections" :key="connection.id" :value="connection.data">{{connection.type.name}}</PropertyRow>
                </div>
                <MessageRow :message="formMessage"></MessageRow>
            </div>
        </div>
        <div class="content-floater" :style="'max-height: '+height+'px'">
            <div class="tabs">
                <router-link class="router-link" :to="'/browseAccounts/account/'+id+'/contacts'">
                    <div class="tab"><h5 class="tab-heading">Kontakte</h5></div>
                </router-link>
                <router-link class="router-link" :to="'/browseAccounts/account/'+id+'/addresses'">
                    <div class="tab"><h5 class="tab-heading">Adressen</h5></div>
                </router-link>
                <router-link class="router-link" :to="'/browseAccounts/account/'+id+'/communications'">
                    <div class="tab"><h5 class="tab-heading">Berichte</h5></div>
                </router-link>
                <router-link class="router-link" :to="'/browseAccounts/account/'+id+'/'+fromName+'/new'">
                    <div class="tab"><h5 class="tab-heading">+</h5></div>
                </router-link>
            </div>
            <div class="tabs-content" :style="'overflow-y: auto;height: '+(height-20)+'px'">
                <router-view
                        :model="model"
                        @updateAddress="updateAddress"
                        @updateContact="updateContact"
                        @updateAdhoc="updateAdhoc"
                        @deleteContact="deleteContact"
                        @saveConnectionToContact="saveConnectionToContact"
                        @saveConnectionToAddress="saveConnectionToAddress"
                        @updateConnection="updateConnection"
                        @deleteConnection="deleteConnection"
                        @saveRemarkToContact="saveRemarkToContact"
                        @saveRemarkToAddress="saveRemarkToAddress"
                        @updateRemark="updateRemark"
                        @deleteRemark="deleteRemark"
                        @reload="loadAccount"
                ></router-view>
            </div>
        </div>
    </div>
</template>

<script>
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import MessageRow from "./bricks/MessageRow";
    import EditableUserComboboxRow from "./EditableUserComboboxRow";
    import EditableCheckboxRow from "./bricks/EditableCheckboxRow";
    import ServiceRequest from "../ServiceRequest";
    import EditableOptionsRow from "./bricks/EditableOptionsRow";
    import EditableAccountLevelOptionRow from "./EditableAccountLevelOptionRow";
    import PanelHeader from "./bricks/PanelHeader";
    import PropertyRow from "./bricks/PropertyRow";
    import EditableSectorOptionRow from "./EditableSectorOptionRow";
    import EditableDateRow from "./bricks/EditableDateRow";
    import DateFormat from "../DateFormat";
    import AppState from "../AppState";
    import Utils from "../Utils";

    export default {
        name: "Account",
        components: {
            EditableDateRow,
            EditableSectorOptionRow,
            PropertyRow,
            EditableAccountLevelOptionRow,
            EditableOptionsRow,
            EditableCheckboxRow,
            EditableUserComboboxRow,
            EditablePropertyRow,
            MessageRow,
            PanelHeader,
        },
        props: {
            id: null,
            height: 0,
        },
        data () {
            return {
                model: {},
                formMessage: '',
                fromName: '',
                lastTabRouteRedirect: false,
                service: new ServiceRequest(),
                enterRoute: {},
                levels: null,
                accountManagerName: null,
                sectors: null,
            }
        },
        methods: {
            deleteRemark (id) {
                this.service.url = "json/remark/delete/" +id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            updateRemark (remark) {
                this.service.url = "json/remark";
                this.service.obj = remark;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            saveRemarkToAddress (remark) {
                this.service.url = "json/remark/toAddress";
                this.service.obj = remark;
                this.service.doPost((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            saveRemarkToContact (remark) {
                this.service.url = "json/remark/toContact";
                this.service.obj = remark;
                this.service.doPost((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            deleteConnection (id) {
                this.service.url = "json/connection/delete/" +id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            updateConnection (connection) {
                this.service.url = "json/connection";
                this.service.obj = connection;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            saveConnectionToAddress (connection) {
                this.service.url = "json/connection/toAddress";
                this.service.obj = connection;
                this.service.doPost((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            saveConnectionToContact (connection) {
                this.service.url = "json/connection/toContact";
                this.service.obj = connection;
                this.service.doPost((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.loadAccount();
                    }
                });
            },
            deleteContact (id) {
                this.service.url = "json/contact/delete/" +id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Kontakt gelöscht";
                        this.loadAccount();
                    }
                });
            },
            updateAdhoc (account) {
                this.putAdhoc(this.id, account);
            },
            updateContact (account) {
                this.putAccountContact(this.id, account);
            },
            updateAddress (address) {
                this.service.url = "json/address";
                this.service.obj = address;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Adresse geändert";
                        // this.loadAccount();
                    }
                });
            },
            updateSector (value) {
                const account = {};
                account.sector = value;
                this.putAccountOnly(this.id, account);
            },
            updateVerbotskunde (value) {
                const account = {};
                account.verbotskunde = value;
                this.putAccountOnly(this.id, account);
            },
            updateUser (value) {
                const account = {};
                account.accountManager = {
                    id: value.id,
                };
                this.putAccountOnly(this.id, account);
            },
            updateNextContact (value) {
                const account = {};
                account.nextContact = value;
                this.putAccountOnly(this.id, account);
            },
            updateMnemonic (value) {
                const account = {};
                account.mnemonic = value;
                this.putAccountOnly(this.id, account);
            },
            updateName (value) {
                const account = {};
                account.name = value;
                this.putAccountOnly(this.id, account);
            },
            updateLevel (value) {
                const account = {};
                account.level = value;
                this.putAccountOnly(this.id, account);
            },
            loadAccount () {
                if (this.id) {
                    this.service.url = "json/account/" + this.id;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error(data);
                        } else {
                            AppState.lastAccountId = this.id // feels wrong here
                            data.address = {};
                            this.model = data;
                            this.model.contacts.forEach(contact => {
                                switch (contact.gender) {
                                    case 'w':
                                        contact.gender = {
                                            id: 'w',
                                            name: 'weiblich',
                                        }
                                        break;
                                    case 'm':
                                        contact.gender = {
                                            id: 'm',
                                            name: 'männlich',
                                        }
                                        break;
                                    case 'd':
                                        contact.gender = {
                                            id: 'd',
                                            name: 'nicht angegeben',
                                        }
                                        break;
                                    default:
                                        contact.gender = {
                                            id: 'd',
                                            name: 'nicht angegeben',
                                        }
                                }
                            })
                            // AppState.lastAccountId = this.model.id; // store last visited account
                            if(this.model.accountManager) {
                                const first = this.model.accountManager.firstname;
                                const last = this.model.accountManager.lastname;
                                if (first) {
                                    this.accountManagerName = first + ' ' + last;
                                } else {
                                    this.accountManagerName = last;
                                }
                            } else {
                                this.accountManagerName = 'Nicht gesetzt';
                            }
                            this.model.address = this.model.addresses.find(x => x.type.name == 'Hauptadresse');
                        }
                    });
                }
            },
            // putAdhoc needs to reload
            putAdhoc (id, account) {
                this.service.url = "json/account/"+id;
                this.service.obj = account;
                this.service.doPut((error, data) => {
                    if (error) {
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Kunde geändert";
                        this.loadAccount();
                    }
                });
            },
            // Account fields have changed -> reload
            putAccountOnly (id, account) {
                this.service.url = "json/account/"+id;
                this.service.obj = account;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Kunde geändert";
                        this.loadAccount();
                    }
                });
            },
            // reload
            putAccountContact (id, account) {
                this.service.url = "json/account/"+id;
                this.service.obj = account;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Kunde geändert";
                        this.loadAccount();
                    }
                });
            },
            // no reload
            putAccount (id, account) {
                this.service.url = "json/account/"+id;
                this.service.obj = account;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.accountsFound = data;
                        this.formMessage = "Kunde geändert";
                        // this.loadAccount();
                    }
                });
            },
            postAccount () {
                this.service.url = "json/account";
                this.service.obj = this.model;
                this.service.doPost((error, data) => {
                    if (error) {
                        console.error(data);
                        this.formMessage = 'Kunde nicht gespeichert: '+data;
                    } else {
                        this.model = data;
                        this.formMessage = 'Kunde gespeichert';
                    }
                });
            },
            loadLevels () {
                this.service.url = "json/account/levels";
                this.service.doGet((error, data) => {
                    if (error) {
                    } else {
                        this.levels = data;
                    }
                });
            },
            loadSectors () {
                this.service.url = "json/account/sectors";
                this.service.doGet((error, data) => {
                    if (error) {
                    } else {
                        this.sectors = data;
                    }
                });
            },
        },
        computed: {
            accountAddressName () {
                if (this.model.address.name1) {
                    return this.model.address.name1;
                }
                return '[kein Addressname]'
            },
            accountAddressStreet () {
                if (this.model.address.street) {
                    return this.model.address.street;
                }
                return '[keine Straße]'
            },
            accountAddressTown () {
                let town = '';
                town += this.model.address.countryCode ? this.model.address.countryCode : ''
                town += ' '
                town += this.model.address.zip ? this.model.address.zip : ''
                town += ' '
                town += this.model.address.town ? this.model.address.town : '[keine Stadt]'
                return town
            }
        },
        watch: {
            id () {
                if(!this.id) {
                    this.formMessage = 'Neuer Account';
                    return;
                }
                this.loadAccount();
            },
            $route (to, from) {
                if (from.name === 'newSub') {
                    this.loadAccount();
                }
                this.fromName = to.name;
            },
        },
        mounted () {
            if (this.id) {
                // this.loadAccount();
            }
            this.loadLevels();
            this.loadSectors();
        },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                vm.fromName = to.name;
                vm.loadAccount();
            });
        },
        beforeRouteUpdate (to, from, next) {
            // keep actual tab when switching ids:
            const fromTab = from.path.substring(from.path.lastIndexOf('/')+1, from.path.length);
            const fromRoot = from.path.replace('/'+fromTab, '');
            const fromId = fromRoot.substring(fromRoot.lastIndexOf('/')+1, fromRoot.length);
            const toTab = to.path.substring(to.path.lastIndexOf('/')+1, to.path.length);
            if (fromTab === 'new' || toTab === 'new') {
                next();
                return;
            }
            const toRoot = to.path.replace('/'+toTab, '');
            const toId = toRoot.substring(toRoot.lastIndexOf('/')+1, toRoot.length);
            if (fromId !== toId && !this.lastTabRouteRedirect) {
                // the id has changed, redirect to from tab
                const toRoute = toRoot+'/'+fromTab;
                this.lastTabRouteRedirect = true;
                // this.loadAccount();
                next({path: toRoute});
            } else {
                this.lastTabRouteRedirect = false;
                next();
            }
        }
    }
</script>

<style lang="sass" scoped>
    .account
        display: grid
        grid-template-columns: 1fr 1fr
        grid-gap: 10px

    .tabs
        display: grid
        grid-template-columns: repeat(3, 3fr) 1fr
        margin: 0 0 -5px 0
        width: 100%

    .tab
        justify-content: center
        padding: 0 8px
        border-top: 1px solid midnightblue
        border-left: 1px solid midnightblue
        border-right: 1px solid midnightblue
        border-radius: 0px

    h5.tab-heading
        padding: 0 0
        text-align: center

    .router-link
        color: #e9c062 //theme.$sand-orange
        background-color: rgba(12, 20, 70, 0.72) //theme.$transparent-blue

    .router-link-active
        color: #e9c062 //theme.$sand-orange

    .router-link-exact-active
        color: #191970 //theme.$midnight-blue
        background-color: rgb(194, 210, 220) //theme.$sky-blue

</style>
