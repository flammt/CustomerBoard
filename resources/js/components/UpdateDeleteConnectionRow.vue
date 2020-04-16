<template>
    <div id="container" class="form-row">

        <h5 v-if="edit" style="width:100%">
            <select :value="selectedId" @change="typeSelected($event.target.value)">
                <option v-for="item in items" :key="item.id" :value="item.id">{{item.name}}</option>
            </select>
        </h5>
        <h5 v-else >{{model.type.name}}</h5>

        <h5 v-if="edit" style="width:100%">
            <input style="width:95%" type="text" :value="inputConnection" @input="connectionInput($event.target.value)">
        </h5>
        <h5 v-else style="width:100%;align-self: center">{{model.data}}</h5>

        <div style="justify-self: right">
            <div v-if="edit" style="display: flex; justify-content: right; padding-right:5px">
                <OkButton @click="ok"></OkButton>
                <CancelButton @click="cancel"></CancelButton>
            </div>
            <ContextButtonRYS v-else :menu-items="contextMenu" style="justify-self: right" @select="contextAction"></ContextButtonRYS>
        </div>
    </div>
</template>

<script>
    import CancelButton from "./bricks/CancelButton";
    import OkButton from "./bricks/OkButton";
    import ContextButtonRYS from "./bricks/ContextButtonRYS";

    export default {
        name: "UpdateDeleteConnectionRow",
        components: {
            ContextButtonRYS,
            OkButton,
            CancelButton,
        },
        props: {
            model: null,
            items: Array,
        },
        data () {
            return {
                inputConnection: this.model.data,
                selectedType: this.model.type,
                selectedId: this.model.type.id,
                edit: false,
                contextMenu: [
                    {id:1,
                        code: 1,
                        safe: false,
                        text:'Bearbeiten'},
                    {id:2,
                        code: 2,
                        safe: true,
                        text:'Löschen ...'}
                ],
            }
        },
        methods: {
            connectionInput (value) {
                this.inputConnection = value;
            },
            typeSelected (value) {
                this.selectedType = this.items.find(x => x.id == value);
                this.selectedId = this.selectedType.id;
            },
            cancel () {
                this.edit = !this.edit;
                this.$emit('createCancelled');
            },
            ok () {
                this.edit = !this.edit;
                if (this.selectedType === null) {
                    this.selectedType = this.items[0];
                }
                this.$emit('createUpdateConfirmed', this.model.id, this.selectedType, this.inputConnection);
            },
            switchEdit () {
                this.edit = !this.edit;
            },
            contextAction (item) {
                if(item.code === 1) { // edit
                    this.edit = !this.edit;
                } else if (item.code === 2) { // delete
                    this.$emit('deleteConfirmed', this.model.id);
                }
            },
        },
        mounted () {
            if (this.model.create) {
                this.edit = true;
            }
        },
        watch: {
        }
    }
</script>

<style lang="sass" scoped>
    #container
        display: grid
        grid-template-columns: 2fr 3fr 2fr
        margin-bottom: 2px
        align-items: center
</style>