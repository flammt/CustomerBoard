<template>
    <div class="searchContainer">
        <input id="input" type="text" style="padding-top: 5px;width:100%" :value="text" :placeholder="placeholder" @click="click" @input="input($event.target.value)">
        <div class="searchFloat" v-if="floaterOn">
            <div class="foundList" style="padding-bottom: 5px">
                <h5 class="link" v-for="item in items" :key="item.id" @click="select(item)" @mouseover="">{{item.name}}</h5>
            </div>
            <h5 class="link" style="border:1px solid black;color:red;" @click="floaterOn = false">x</h5>
        </div>
    </div>
</template>

<script>
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "UserInputCombobox",
        components: {
        },
        props: {
            value: '',
            placeholder: '',
        },
        data () {
            return {
                text: this.value,
                inputText: '',
                usersFound: [],
                selectedUser: {},
                cancelSource: null,
                floaterOn: false,
                service: new ServiceRequest(),
            }
        },
        methods: {
            click () {
                this.text = '';
                this.selectedUser = {};
                this.$emit('userSelected', {});
            },
            select (value) {
                this.selectedUser = this.usersFound.find(x => x.id == value.id);
                this.text = value.name;
                this.usersFound = [];
                this.$emit('userSelected', this.selectedUser);
            },
            input (value) {
                this.inputText = value;
                this.text = value;
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
        },
        computed: {
            items () {
                const items = [];
                this.usersFound.forEach(function (user) {
                    items.push({
                        id: user.id,
                        get name() {
                            if(user.firstname) {
                                return user.lastname +', ' +user.firstname;
                            }
                            return user.lastname;
                        }
                    });
                });
                if (items.length > 0) {
                    this.floaterOn = true;
                }
                return items;
            }
        },
        watch: {
            items: function() {
                this.floaterOn = this.items.length !== 0;
            }
        },
    }
</script>

<style scoped>

    .searchContainer {
        position: relative;
        align-items: center;
    }
    .searchFloat {
        background-color: rgb(255, 255, 255);
        display:grid;
        grid-template-columns: 18fr 1fr;
        position:absolute;
        z-index: 255;
        width:100%;
    }
    .foundList {
        display:grid;
        grid-template-columns: 1fr 1fr 1fr;
        width:100%;
        border:1px solid black;
    }
    .link {
        cursor: pointer;
    }
    .link:hover {
        cursor: pointer;
        background-color: #e9c062;
    }
</style>
