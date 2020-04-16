<template>
    <div>
        <div class="panel" v-if="model.addresses && model.addresses.length > 0" v-for="address in model.addresses" :key="address.id">
            <div style="display:flex;justify-content: space-between">
                <PanelHeader v-if="address.type.name == 'Hauptadresse'">Hauptadresse</PanelHeader>
<!--                <PanelHeader v-else>Adresse</PanelHeader>-->
            </div>
            <div style="display: flex">
                <div style="width:100%">
                    <EditableOptionsRow v-if="address.type.name !== 'Hauptadresse'" :items="types" :value="address.type" @change="typeSelected($event)" @confirmed="updateType(address.id)">Typ</EditableOptionsRow>
                    <EditablePropertyRow :value="address.name1" @confirmed="updateName1(address.id, $event)">Feld 1</EditablePropertyRow>
                    <EditablePropertyRow :value="address.name2" @confirmed="updateName2(address.id, $event)">Feld 2</EditablePropertyRow>
                    <EditablePropertyRow :value="address.name3" @confirmed="updateName3(address.id, $event)">Feld 3</EditablePropertyRow>
                    <EditablePropertyRow :value="address.street" @confirmed="updateStreet(address.id, $event)">Straße</EditablePropertyRow>
                    <EditablePropertyRow :value="address.countryCode" @confirmed="updateCountryCode(address.id, $event)">LKZ</EditablePropertyRow>
                    <EditablePropertyRow :value="address.zip" @confirmed="updateZip(address.id, $event)">PLZ</EditablePropertyRow>
                    <EditablePropertyRow :value="address.town" @confirmed="updateTown(address.id, $event)">Stadt</EditablePropertyRow>
                </div>
                <div style="width: 20px; height: 20px; padding: 0px 3px 0 8px;"></div>
            </div>
            <ConnectionsFormPanel
                    :model="address"
                    @save="$emit('saveConnectionToAddress', $event)"
                    @update="$emit('updateConnection', $event)"
                    @delete="$emit('deleteConnection', $event)"
            ></ConnectionsFormPanel>
            <RemarksFormPanel
                    :model="address"
                    @save="$emit('saveRemarkToAddress', $event)"
                    @update="$emit('updateRemark', $event)"
                    @delete="$emit('deleteRemark', $event)"
            ></RemarksFormPanel>
        </div>
    </div>
</template>

<script>
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import EditableOptionsRow from "./bricks/EditableOptionsRow";
    import ServiceRequest from "../ServiceRequest";
    import CaptionPropertyRow from "./bricks/CaptionPropertyRow";
    import PanelHeader from "./bricks/PanelHeader";
    import ConnectionsFormPanel from "./ConnectionsFormPanel";
    import RemarksFormPanel from "./RemarksFormPanel";
    import Utils from "../Utils";

    export default {
        name: "AccountAddresses",
        components: {
            RemarksFormPanel,
            CaptionPropertyRow,
            EditableOptionsRow,
            EditablePropertyRow,
            PanelHeader,
            ConnectionsFormPanel,
        },
        props: {
            model: null,
            height: 500
        },
        data () {
            return {
                address: {
                    name1: '',
                    name2: '',
                    name3: '',
                    street: '',
                    countryCode: '',
                    zip: '',
                    town: '',
                    type: '',
                },
                selectedType: '',
                types: [],
                service: new ServiceRequest(),
            }
        },
        methods: {
            typeSelected (type) {
                this.selectedType = type;
            },
            updateName1 (addressId, value) {
                const address = {
                    id: addressId,
                    name1: value,
                };
                this.$emit('updateAddress', address);
            },
            updateName2 (addressId, value) {
                const address = {
                    id: addressId,
                    name2: value,
                };
                this.$emit('updateAddress', address);
            },
            updateName3 (addressId, value) {
                const address = {
                    id: addressId,
                    name3: value,
                };
                this.$emit('updateAddress', address);
            },
            updateStreet (addressId, value) {
                const address = {
                    id: addressId,
                    street: value,
                };
                this.$emit('updateAddress', address);
            },
            updateCountryCode (addressId, value) {
                const address = {
                    id: addressId,
                    countryCode: value,
                };
                this.$emit('updateAddress', address);
            },
            updateZip (addressId, value) {
                const address = {
                    id: addressId,
                    zip: value,
                };
                this.$emit('updateAddress', address);
            },
            updateTown (addressId, value) {
                const address = {
                    id: addressId,
                    town: value,
                };
                this.$emit('updateAddress', address);
            },
            updateType (addressId) {
                const address = {
                    id: addressId,
                    type: this.selectedType,
                };
                this.$emit('updateAddress', address);
            },
            loadAddressTypes () {
                this.service.url = "json/address/types";
                this.service.doGet((error, data) => {
                    if (error) {
                        console.error(data);
                    } else {
                        this.types = data;
                    }
                });
            }
        },
        watch: {
            model () {
            }
        },
        beforeRouteLeave (to, from, next) {
            // set user variable to determine target for new items in AccountNewSub
            this.$root.fromPath = from.path;
            next();
        },
        mounted() {
            this.loadAddressTypes();
        }
    }
</script>

<style scoped>

</style>
