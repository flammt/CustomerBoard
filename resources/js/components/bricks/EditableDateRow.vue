<template>
    <div id="property-row" class="form-row">
        <h5 style=""><label for="date"><slot></slot></label></h5>
        <h5 v-if="edit" style="width:100%;">
            <input style="width:95%" id="date" type="date" v-model="inputDate" @keypress="keypress($event.keyCode)">
        </h5>
        <h5 v-else style="width:100%;">{{germanDate}}</h5>
        <div style="justify-self: right; justify-items: right">
            <div v-if="edit" style="display: flex; justify-content: right">
                <OkButton @click="ok"></OkButton>
                <CancelButton @click="cancel"></CancelButton>
            </div>
            <EditButton v-else @click="switchEdit"></EditButton>
        </div>
    </div>
</template>

<script>
    import CancelButton from "./CancelButton";
    import OkButton from "./OkButton";
    import EditButton from "./EditButton";
    import moment from "moment";

    export default {
        name: "EditableDateRow",
        components: {
            EditButton,
            OkButton,
            CancelButton,
        },
        props: {
            value: null,
        },
        data () {
            return {
                date: this.value,
                edit: false
            }
        },
        methods: {
            keypress (code) {
                // accept enter to confirm
                if (code === 13) {
                    this.ok();
                }
            },
            cancel () {
                this.date = this.value;
                this.switchEdit();
            },
            ok () {
                if (this.value != this.date) {
                    // only confirm changed value
                    this.switchEdit();
                    this.$emit('confirmed', this.date);
                }
            },
            switchEdit () {
                this.edit = !this.edit;
            }
        },
        computed: {
            inputDate: {
                get () {
                    return moment(this.date).format('YYYY-MM-DD');
                },
                set (date) {
                    this.date = date;
                },
            },
            germanDate () {
                if (this.date) {
                    return moment(this.date).format('DD.MM.YYYY');
                }
                return 'Nicht gesetzt';
            }
        },
        watch: {
            value () {
                this.date = this.value;
            }
        }
    }
</script>

<style lang="sass" scoped>
    #property-row
        display: grid
        grid-template-columns: 7fr 13fr 3fr
        padding: 0 10px 0 0
        margin: 5px 0 5px 0
        align-items: center
</style>
