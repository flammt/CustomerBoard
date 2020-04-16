<template>
    <div class="sector">
        <div class="content-floater">
            <div style="display: flex">
                <select multiple size="8" style="width:100%" @change="goto($event.target.value)">
                    <option v-for="sector in model" :key="sector.id" :value="sector.id">{{sector.name}}</option>
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
        name: "Sector",
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
                    this.$router.replace('/auxData/sector/'+id);
                }
            },
            reload () {
                this.loadSectors();
            },
            loadSectors () {
                this.service.url = "json/aux/sectors";
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Loading Sector failed: ' + data);
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
            this.loadSectors();
        }
    }
</script>

<style scoped>
    .sector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        grid-gap: 10px;
    }
</style>