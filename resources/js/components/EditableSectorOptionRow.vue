<template>
    <div id="property-row" class="form-row">
        <h5 style="align-self: center"><slot></slot></h5>
        <h5 v-if="edit" style="width:100%;">
            <select id="name" :value="selectedSector.id" @change="sectorSelected($event.target.value)">
                <option v-for="sector in items" :key="sector.id" :value="sector.id">{{sector.name}}</option>
            </select>
        </h5>
        <h5 v-else style="width:100%;">{{text}}</h5>
        <div style="justify-self: right">
            <div v-if="edit" style="display: flex; justify-content: right">
                <OkButton @click="ok"></OkButton>
                <CancelButton @click="cancel"></CancelButton>
            </div>
            <EditButton v-else @click="switchEdit" style="justify-self: right"></EditButton>
        </div>
    </div>
</template>

<script>
    import CancelButton from "./bricks/CancelButton";
    import OkButton from "./bricks/OkButton";
    import EditButton from "./bricks/EditButton";
    import SectorOptionRow from "./SectorOptionRow";

    export default {
        name: "EditableAccountSectorOptionRow",
        components: {
            SectorOptionRow,
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            items: null,
            value: null,
        },
        data () {
            return {
                text: null,
                edit: false,
                selectedSector: {},
            }
        },
        methods: {
            sectorSelected (value) {
                const selected = this.items.find(x => x.id == value);
                this.selectedSector = selected;
            },
            cancel () {
                this.edit = !this.edit;
            },
            ok () {
                if (Object.entries(this.selectedSector).length > 0) {
                    // ok not possible with no user selected
                    this.edit = !this.edit;
                    this.$emit('confirmed', this.selectedSector);
                }
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        watch: {
            value () {
                if (this.value) {
                    this.text = this.value.name;
                    this.selectedSector = this.value
                } else {
                    this.text = 'Nicht gesetzt';
                    this.selectedSector = this.items[0]
                }
            }
        }
    }
</script>

<style scoped>
    #property-row {
        display: grid;
        grid-template-columns: 7fr 13fr 3fr;
        padding: 0 10px 0 0;
        margin: 5px 0 5px 0;
    }
</style>
