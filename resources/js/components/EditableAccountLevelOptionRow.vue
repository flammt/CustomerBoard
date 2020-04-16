<template>
    <div id="property-row" class="form-row">
        <h5><slot></slot></h5>
        <h5 v-if="edit" style="justify-self: right;width:100%;">
            <select id="name" :value="value.id" @change="levelSelected($event.target.value)">
                <option v-for="level in items" :key="level.id" :value="level.id">{{level.description}}</option>
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
    import AccountLevelOptionRow from "./AccountLevelOptionRow";

    export default {
        name: "EditableAccountLevelOptionRow",
        components: {
            AccountLevelOptionRow,
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
                text: '',
                edit: false,
                selectedLevel: {},
            }
        },
        methods: {
            levelSelected (value) {
                const selected = this.items.find(x => x.id == value);
                this.selectedLevel = selected;
            },
            cancel () {
                this.switchEdit();
            },
            ok () {
                if (Object.entries(this.selectedLevel).length > 0) {
                    // ok not possible with no user selected
                    this.switchEdit();
                    this.$emit('confirmed', this.selectedLevel);
                }
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        watch: {
            value () {
                if (this.value) {
                    this.text = this.value.description;
                    this.selectedLevel = this.value;
                } else {
                    this.text = 'Nicht gesetzt';
                    this.selectedLevel = this.items[0];
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
        align-items: center;
    }
</style>
