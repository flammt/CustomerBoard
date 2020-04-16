<template>
    <div class="account">
        <div class="content-floater">
            <div style="display: flex">
                <select multiple size="8" style="width:100%" @change="goto($event.target.value)">
                    <option v-for="type in model" :key="type.id" :value="type.id">{{type.name}}</option>
                </select>
                <button type="button" style="height:24px" @click="niu">Neu</button>
            </div>
        </div>
        <router-view style="width:100%" @reload="reload"></router-view>
    </div>
</template>

<script>
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "RemarkType",
        data () {
            return {
                model: [],
                selectedId: null,
                service: new ServiceRequest(),
            }
        },
        methods: {
            goto (id) {
                if (id) {
                    this.selectedId = id;
                    this.$router.replace('/auxData/remarkType/'+id);
                }
            },
            reload () {
                this.loadTypes();
            },
            loadTypes () {
                this.service.url = "json/aux/remarkTypes";
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Loading RemarkType failed: ' + data);
                    } else {
                        this.model = data;
                    }
                });
            },
            niu () {
                this.goto('new');
            }
        },
        mounted () {
            this.loadTypes();
        }
    }
</script>

<style scoped>
    .account {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
    }
</style>