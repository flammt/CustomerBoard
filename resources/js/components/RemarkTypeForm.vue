<template>
    <div class="content-floater" style="max-height:660px">
        <FormTextRow :value="typeName" @input="nameInput">Name</FormTextRow>
        <div style="display:flex;justify-content: right">
            <button type="button" @click="save">Speichern</button>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "./bricks/FormTextRow";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "RemarkTypeForm",
        components: {
            FormTextRow,
        },
        props: {
            id: null,
        },
        data () {
            return {
                type: {},
                service: new ServiceRequest(),
            }
        },
        methods: {
            save () {
                if (!this.type) {
                    return;
                }
                if (this.type.id) {
                    this.service.url = "json/aux/remarkType";
                    this.service.obj = this.type;
                    this.service.doPut((error, data) => {
                        if (error) {
                            console.error('Updating RemarkType failed: ' + data);
                        } else {
                            this.$emit('reload');
                        }
                    });
                } else {
                    this.service.url = "json/aux/remarkType";
                    this.service.obj = this.type;
                    this.service.doPost((error, data) => {
                        if (error) {
                            console.error('Saving RemarkType failed: ' + data);
                        } else {
                            this.$emit('reload');
                        }
                    });
                }
            },
            nameInput (value) {
                this.type.name = value;
            },
            load () {
                this.service.url = "json/aux/remarkType/"+this.id;
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error('Load RemarkType failed: ' + data);
                    } else {
                        this.type = data;
                    }
                });
            }
        },
        computed: {
            typeName () {
                if (this.type) {
                    return this.type.name;
                }
            }
        },
        watch: {
            id () {
                if (this.id) {
                    if (this.id === 'new') {
                        this.type = {};
                    } else {
                        this.load();
                    }
                }
            }
        },
        mounted () {
            if (this.id) {
                if (this.id === 'new') {
                    this.type = {};
                } else {
                    this.load();
                }
            } else {
                this.type = {};
            }
        }
    }
</script>

<style scoped>

</style>