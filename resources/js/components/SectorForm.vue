<template>
    <div class="content-floater" style="max-height:660px">
        <FormTextRow :value="sectorName" @input="nameInput">Name</FormTextRow>
        <div style="display:flex;justify-content: right">
            <button type="button" @click="save">Speichern</button>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "./bricks/FormTextRow";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "SectorForm",
        components: {
            FormTextRow,
        },
        props: {
            id: null,
        },
        data () {
            return {
                sector: {},
                service: new ServiceRequest(),
            }
        },
        methods: {
            save () {
                if (!this.sector) {
                    return;
                }
                if (this.sector.id) {
                    this.service.url = "json/aux/sector";
                    this.service.obj = this.sector;
                    this.service.doPut((error, data) => {
                        if (error) {
                            console.error('Updating Sector failed: ' + data);
                        } else {
                            this.$emit('reload');
                        }
                    });
                } else {
                    this.service.url = "json/aux/sector";
                    this.service.obj = this.sector;
                    this.service.doPost((error, data) => {
                        if (error) {
                            console.error('Saving Sector failed: ' + data);
                        } else {
                            this.$emit('reload');
                        }
                    });
                }
            },
            nameInput (value) {
                this.sector.name = value;
            },
            load () {
                this.service.url = "json/aux/sector/"+this.id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Load Sector failed: ' + data);
                    } else {
                        this.sector = data;
                    }
                });
            }
        },
        computed: {
            sectorName () {
                if (this.sector) {
                    return this.sector.name;
                }
            }
        },
        watch: {
            id () {
                if (this.id) {
                    if (this.id === 'new') {
                        this.sector = {};
                    } else {
                        this.load();
                    }
                }
            }
        },
        mounted () {
            if (this.id) {
                if (this.id === 'new') {
                    this.sector = {};
                } else {
                    this.load();
                }
            } else {
                this.sector = {};
            }
        }
    }
</script>

<style scoped>

</style>