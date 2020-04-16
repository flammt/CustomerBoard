<template>
    <div>
        <h3>Kunden anzeigen</h3>
        <div id="browse-accounts">
            <div class="content-floater">
                <div>
                    <input type="text"
                           placeholder="k:Krz l:LKZ n:Nam o:Ort p:PLZ"
                           style="width:100%"
                           :value="searchInput"
                           @input="searchAccount($event.target.value)"
                           @keypress="keyPressed($event.keyCode)"
                           @keydown="keyDown($event.keyCode)"
                    >
                    <LinkList v-if="links" :items="links" :value="selectedLink"></LinkList>
                </div>
                <div style="position:relative; padding-top:40px">
                    <button style="position:absolute;bottom:0;left:0;" class="button green-button" @click="newAccount">Neu</button>
                </div>
            </div>
            <router-view :height="height"></router-view>
        </div>
    </div>
</template>

<script>
    import TextRow from "./bricks/TextRow";
    import FormTextRow from "./bricks/FormTextRow";
    import FormCheckboxRow from "./bricks/FormCheckboxRow";
    import FormValidationRow from "./bricks/FormValidationRow";
    import User from "./UserEdit";
    import ServiceRequest from "../ServiceRequest";
    import AppState from "../AppState";
    import Utils from "../Utils";
    import LinkList from "./bricks/LinkList";

    export default {
        name: "BrowseAccounts",
        components: {
            LinkList,
            User,
            TextRow,
            FormTextRow,
            FormCheckboxRow,
            FormValidationRow,
        },
        props: {
            height: null
        },
        data () {
            return {
                searchInput: '',
                accountsFound: [],
                selectedAccount: {},
                links: null,
                selectedLink: null,
                selectedNo: null,
                service: new ServiceRequest(),
            }
        },
        methods: {
            keyDown (code) {
                switch (code) {
                    case 40: // arrow down
                        if (this.selectedNo === null) {
                            if (this.links) {
                                if (this.links.length > 0) {
                                    this.selectedNo = 0
                                }
                                this.selectedLink = this.links[this.selectedNo]
                            }
                        } else {
                            this.selectedNo++;
                            if (this.selectedNo === this.links.length) {
                                this.selectedNo = 0
                            }
                            this.selectedLink = this.links[this.selectedNo]
                        }
                        break;
                    case 38: // arrow up
                        if (this.selectedNo === null) {
                            if (this.links) {
                                if (this.links.length > 0) {
                                    this.selectedNo = this.links.length -1
                                }
                                this.selectedLink = this.links[this.selectedNo]
                            }
                        } else {
                            this.selectedNo--;
                            if (this.selectedNo === -1) {
                                this.selectedNo = this.links.length -1
                            }
                            this.selectedLink = this.links[this.selectedNo]
                        }
                        break;
                }
            },
            keyPressed (code) {
                switch (code) {
                    case 13: // enter
                        if (this.accountsFound.length === 1) {
                            this.$router.push('/browseAccounts/account/'+this.accountsFound[0].id)
                        } else if (this.selectedLink) {
                            this.$router.push('/browseAccounts/account/'+this.selectedLink.id)
                        }
                        break;
                }
            },
            newAccount () {
                this.$router.push('/browseAccounts/accountNew').catch(() => {}); // consume exception ("uncaught exception: Object")
            },
            searchAccount(input) {
                if (input.length > 2) {
                    this.service.cancel();
                    this.service.url = "json/account/search/"+input;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error(data);
                        } else {
                            this.accountsFound = data;
                            this.links = this.accountsFound.map(account => {
                                return {
                                    id: account.id,
                                    link: '/browseAccounts/account/'+account.id,
                                    text: this.description(account),
                                    active: false
                                }
                            })
                            this.selectedNo = null
                        }
                    });
                }
                this.searchInput = input;
            },
            description (account) {
                let desc = account.name;
                if (account.addresses && account.addresses[0]) {
                    if (account.addresses[0].town) {
                        desc += ' '+account.addresses[0].town;
                    } else {
                        desc += ' [kein Ort]'
                    }
                }
                return desc;
            }
        },
        computed: {
            computeMaxHeight () {
                return Utils.pixelByPercent(Utils.getScreenHeight(), 75)
            },
        },
        beforeRouteEnter (to, from, next) {
            let accountExplicit = false
            to.matched.forEach(match => {
                if (match.name == 'account') {
                    accountExplicit = true
                }
            })
            if (accountExplicit) {
                next()
            } else if (AppState.lastAccountId > 0) {
                next(vm => vm.$router.push('/browseAccounts/account/'+AppState.lastAccountId))
            } else {
                next()
            }
        },
        mounted () {
        },
    }
</script>

<style lang="sass" scoped>
    #browse-accounts
        display: grid
        grid-template-columns: 1fr 4fr
        grid-gap: 10px
    input
        margin-top: 5px
        width: 90%

</style>
