<template>
    <div class="panel">
<!--        <div style="display:flex;justify-content: space-between">-->
<!--            <PanelHeader>Besuchsbericht</PanelHeader>-->
<!--        </div>-->
        <EditableDateRow :value="model.date" @confirmed="updateDate">Datum</EditableDateRow>
        <EditableContactComboboxRow :value="contactName(model.contact)" :account-id="accountId" @confirmed="updateContact">Gesprächspartner</EditableContactComboboxRow>
        <EditableUserComboboxRow :value="userName" @confirmed="updateUser">Kontaktperson</EditableUserComboboxRow>
        <EditableOptionsRow :value="model.type" :items="types" @confirmed="updateType">Gesprächsart</EditableOptionsRow>
        <EditableTextAreaPropertyRow :value="model.memo" @confirmed="updateMemo">Notitzen</EditableTextAreaPropertyRow>
    </div>
</template>

<script>
    import PanelHeader from "./bricks/PanelHeader";
    import EditableContactComboboxRow from "./EditableContactComboboxRow";
    import EditableDateRow from "./bricks/EditableDateRow";
    import EditableUserComboboxRow from "./EditableUserComboboxRow";
    import DateFormat from "../DateFormat";
    import EditableOptionsRow from "./bricks/EditableOptionsRow";
    import EditableTextAreaPropertyRow from "./bricks/EditableTextAreaPropertyRow";

    export default {
        name: "Communication",
        components: {
            EditableTextAreaPropertyRow,
            EditableOptionsRow,
            EditableDateRow,
            PanelHeader,
            EditableContactComboboxRow,
            EditableUserComboboxRow,
            DateFormat,
        },
        props: {
            model: null,
            accountId: null,
            types: null,
        },
        methods: {
            updateContact (contact) {
                const communication = {
                    id: this.model.id,
                    contact: contact,
                };
                this.$emit('update', communication);
            },
            updateUser (user) {
                const communication = {
                    id: this.model.id,
                    user: user,
                };
                this.$emit('update', communication);
            },
            updateType (type) {
                const communication = {
                    id: this.model.id,
                    type: type,
                };
                this.$emit('update', communication);
            },
            updateDate (date) {
                const communication = {
                    id: this.model.id,
                    date: date,
                };
                this.$emit('update', communication);
            },
            updateMemo (memo) {
                const communication = {
                    id: this.model.id,
                    memo: memo,
                };
                this.$emit('update', communication);
            },
            contactName (contact) {
                if (contact.firstname) {
                    return contact.firstname+' '+contact.lastname;
                }
                return contact.lastname;
            }
        },
        watch: {
            model () {
            }
        },
        mounted() {
        },
        computed: {
            userName () {
                return this.model.user.firstname +' ' +this.model.user.lastname;
            }
        }
    }
</script>

<style scoped>

</style>