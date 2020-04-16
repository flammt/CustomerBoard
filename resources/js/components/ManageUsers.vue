<template>
    <div>
        <h3>Benutzer verwalten</h3>
        <div id="manage-users">
            <div id="search" class="content-floater">
                <div>
                    <input type="text" placeholder="Name (mind. 3 Zeichen)" @input="searchUser($event.target.value)">
                    <div v-for="user in usersFound" :key="user.id">
                        <router-link :to="'/manageUsers/user/'+user.id">
                            <TextRow>{{user.lastname}}, {{user.firstname}}</TextRow>
                        </router-link>
                    </div>
                </div>
                <div style="position:relative; padding-top:40px">
                    <button style="position:absolute;bottom:0;left:0;" class="button green-button" @click="formNew">Neu</button>
                </div>
            </div>
            <div id="form" class="content-floater">
                <router-view></router-view>
            </div>
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

    export default {
        name: "ManageUsers",
        components: {
            User,
            TextRow,
            FormTextRow,
            FormCheckboxRow,
            FormValidationRow,
        },
        data () {
            return {
                searchInput: '',
                usersFound: [],
                selectedUser: {},
                cancelSource: null,
                formRowHeight: 0,
                service: new ServiceRequest(),
            }
        },
        methods: {
            formNew () {
                this.$router.push('/manageUsers/user/new');
            },
            searchUser(input) {
                this.searchInput = input;
                this.searchRequest();
            },
            searchRequest() {
                const currentInput = this.searchInput;
                if(currentInput.length > 2) {
                    this.service.url = "json/user/search/"+currentInput;
                    this.service.doGet((error, data) => {
                        if (error) {
                            console.error('Loading User failed: ' + data);
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
        },
    }
</script>

<style scoped>
    #manage-users {
        display: grid;
        grid-template-columns: 1fr 3fr 2fr;
        grid-gap: 10px;
    }
    #search {
        display: grid;
        grid-template-rows: auto auto;
    }
    input {
        margin-top: 5px;
        /*padding-right: 0;*/
        width: 90%
    }
</style>
