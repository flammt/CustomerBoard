<template>
    <div :style="'height: '+height+'px'">
        <Communication
                v-for="communication in model.communications"
                :key="communication.id"
                :model="communication"
                :account-id="model.id"
                :types="types"
                @update="update"
        ></Communication>
    </div>
</template>

<script>
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import EditableTextAreaPropertyRow from "./bricks/EditableTextAreaPropertyRow";
    import EditableOptionsRow from "./bricks/EditableOptionsRow";
    import PropertyRow from "./bricks/PropertyRow";
    import PanelHeader from "./bricks/PanelHeader";
    import EditableContactComboboxRow from "./EditableContactComboboxRow";
    import Communication from "./Communication";
    import ServiceRequest from "../ServiceRequest";

    export default {
        name: "AccountCommunications",
        components: {
            Communication,
            EditableContactComboboxRow,
            PropertyRow,
            EditableOptionsRow,
            EditableTextAreaPropertyRow,
            EditablePropertyRow,
            PanelHeader,
        },
        props: {
            model: {},
            lines: 10,
            height: 500
        },
        data () {
            return {
                types: [],
                selectedType: '',
                service: new ServiceRequest(),
            }
        },
        methods: {
            update (communication) {
                this.service.url = "json/communication";
                this.service.obj = communication;
                this.service.doPut((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.$emit('reload');
                    }
                });
            },
        },
        watch: {
            model: function () {
            }
        },
        mounted () {
            this.service.url = "json/communication/types";
            this.service.doGet((error, data) => {
                if (error) {
                    console.error(data);
                } else {
                    this.types = data;
                }
            });
        },
        beforeRouteLeave (to, from, next) {
            // set user variable to determine target for new items in AccountNewSub
            this.$root.fromPath = from.path;
            next();
        }
    }
</script>

<style scoped>

</style>
