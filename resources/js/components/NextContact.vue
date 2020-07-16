<template>
    <div class="panel">
        <div style="display:flex;justify-content: space-between">
            <PanelHeader><router-link :to="'/browseAccounts/account/'+model.id">{{accountCaption}}</router-link></PanelHeader>
            <PanelHeader>{{model.type_name}}</PanelHeader>
            <PanelHeader>mit {{model.contact_lastname}}, {{model.contact_firstname}}</PanelHeader>
            <PanelHeader>am {{createdDate}}</PanelHeader>
            <input style="margin:10px 0 10px 0" type="date" :value="nextContactDate" @change="dateChanged($event.target.value)" @blur="focusLost" @keydown="keyPressed($event.target, $event.keyCode)">
        </div>
        <div style="display:flex;justify-content: space-evenly">
            <TextRow style="width:80%;margin-right:10px">{{communicationMemo}}</TextRow>
            <TextRow style="white-space: nowrap">{{accountManagername}}</TextRow>
        </div>
    </div>
</template>

<script>
    import PanelHeader from "./bricks/PanelHeader";
    import DateFormat from "../DateFormat";
    import TextRow from "./bricks/TextRow";
    import Utils from "../Utils";
    import AppState from "../AppState";

    export default {
        name: "NextContact",
        components: {
            TextRow,
            PanelHeader
        },
        props: {
            model: null,
        },
        data () {
            return {
                nextContact: null
            }
        },
        methods: {
            keyPressed (target, code) {
                switch (code) {
                    case 13: // enter
                        // leaves input focus on enter
                        target.blur()
                        break;
                }
            },
            focusLost () {
                // date change with selector fires on every change (actual editing NextContact probably disappears)
                const account = {
                    id: this.model.id,
                    nextContact: this.nextContact,
                };
                this.$emit('dateChanged', account);
            },
            dateChanged (value) {
                this.nextContact = value;
            },
        },
        computed: {
            nextContactDate () {
                return DateFormat.cutTime(this.model.next_contact)
            },
            createdDate () {
                return DateFormat.getGermanDateTime(this.model.created_at)
            },
            accountCaption () {
                return Utils.notEmptyConcatReplace([this.model.name1, ' ', this.model.street, ' ', this.model.country_code, ' ', this.model.zip, ' ', this.model.town],
                ['[Firma]', ' ', '[Straße]', ' ', '[LKZ]', ' ', '[PLZ]', ' ', '[Ort]'])
            },
            accountManagername () {
                return Utils.notEmptyConcatReplace([this.model.firstname, ' ', this.model.lastname], ['[Vorname]', ' ', '[Name]'])
            },
            communicationMemo () {
                return this.model.memo;
            }
        },
    }
</script>

<style scoped>

</style>
