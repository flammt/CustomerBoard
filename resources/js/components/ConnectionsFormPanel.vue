<template>
    <div class="inside-panel" style="display:flex">
        <div style="width:100%">
            <UpdateDeleteConnectionRow
                    v-for="connection in connections"
                    :key="connection.id"
                    :model="connection"
                    :items="connectionTypes"
                    @createUpdateConfirmed="createUpdate"
                    @deleteConfirmed="$emit('delete', $event)"
                    @createCancelled="createCancelled"
            ></UpdateDeleteConnectionRow>
            <PanelHeader v-if="connections.length == 0">Verbindungen</PanelHeader>
        </div>
        <AddButton @click="add"></AddButton>
    </div>
</template>

<script>
    import UpdateDeleteConnectionRow from "./UpdateDeleteConnectionRow";
    import AddButton from "./bricks/AddButton";
    import PanelHeader from "./bricks/PanelHeader";
    import ServiceRequest from "../ServiceRequest";

    export default {
        components: {
            AddButton,
            UpdateDeleteConnectionRow,
            PanelHeader,

        },
        name: "ConnectionsFormPanel",
        props: {
            model: {},
        },
        data () {
            return {
                connections: this.model.connections,
                connectionCreating: null,
                connectionCreatingIndex: null,
                connectionTypes: [],
                service: new ServiceRequest(),
            }
        },
        methods: {
            createUpdate (id, type, data) {
                if (this.connectionCreating) { // save
                    const connection = {
                        parentId: this.model.id,
                        typeId: type.id,
                        data: data,
                    };
                    this.connections.splice(this.connectionCreatingIndex, 1);
                    this.connectionCreating = null;
                    this.$emit('save', connection);
                } else { // update
                    const connection = {
                        id: id,
                        typeId: type.id,
                        data: data,
                    };
                    this.connections.splice(this.connectionCreatingIndex, 1);
                    this.connectionCreating = null;
                    this.connectionCreatingIndex = -1;
                    this.$emit('update', connection);
                }
            },
            add () {
                if (this.connectionCreating) {
                    return;
                }
                this.connectionCreatingIndex = this.connections.length;
                this.connectionCreating = {
                    id: this.connectionCreatingIndex,
                    type: this.connectionTypes[0],
                    data: '',
                    create: true,
                };
                this.connections.push(this.connectionCreating);
            },
            createCancelled () {
                if (this.connectionCreating) {
                    this.connections.splice(this.connectionCreatingIndex, 1);
                    this.connectionCreating = null;
                    this.connectionCreatingIndex = -1;
                }
            }
        },
        watch: {
            model () {
                this.connections = this.model.connections;
            }
        },
        mounted () {
            this.service.url = "json/connection/types";
            this.service.doGet((error, data) => {
                if (error) {
                    console.error('Load ConnectionType failed: ' + data);
                } else {
                    this.connectionTypes = data;
                }
            });
        }
    }
</script>

<style scoped>

</style>