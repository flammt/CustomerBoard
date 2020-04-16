<template>
    <div :style="'max-height: 100px'">
        <div class="panel" v-if="model" v-for="contact in model.contacts" :key="contact.id">
            <div v-if="!contact.is_adhoc">
<!--                <div style="display:flex;justify-content: space-between">-->
<!--                    <PanelHeader></PanelHeader>-->
<!--                </div>-->
                <div style="display: flex; padding-top: 10px">
                    <div style="width:100%">
                        <EditableRowContainer :caption="contactName(contact)">
                            <div style="padding-top:1px"></div>
                            <EditablePropertyRow :value="contact.title" @confirmed="updateTitle(contact.id, $event)">Titel</EditablePropertyRow>
                            <EditablePropertyRow :value="contact.firstname" @confirmed="updateFirstname(contact.id, $event)">Vorname</EditablePropertyRow>
                            <EditablePropertyRow :value="contact.lastname" @confirmed="updateLastname(contact.id, $event)">Nachname</EditablePropertyRow>
                            <EditableOptionsRow :value="contact.gender" :items="genderItems" @confirmed="updateGender(contact.id, $event)">Gender</EditableOptionsRow>
                        </EditableRowContainer>
                        <div style="padding:2px"></div>
                        <EditableRowContainer :caption="contactPosition(contact)">
                            <div style="padding-top:1px"></div>
                            <EditablePropertyRow :value="contact.department" @confirmed="updateDepartment(contact.id, $event)">Abteilung</EditablePropertyRow>
                            <EditablePropertyRow :value="contact.position" @confirmed="updatePosition(contact.id, $event)">Position</EditablePropertyRow>
                        </EditableRowContainer>
                    </div>
                    <ContextButtonRYS :menu-items="regularContextMenu" :object="contact" @select="contextAction"></ContextButtonRYS>
                </div>
                <div style="padding-top:5px"></div>
                <ConnectionsFormPanel
                        :model="contact"
                        @save="$emit('saveConnectionToContact', $event)"
                        @update="$emit('updateConnection', $event)"
                        @delete="$emit('deleteConnection', $event)"
                ></ConnectionsFormPanel>
                <div style="padding-top:5px"></div>
                <RemarksFormPanel
                        :model="contact"
                        @save="$emit('saveRemarkToContact', $event)"
                        @update="$emit('updateRemark', $event)"
                        @delete="$emit('deleteRemark', $event)"
                ></RemarksFormPanel>
            </div>
            <div v-else>
                <div style="display:flex;justify-content: space-between">
                    <PanelHeader>Temporärer Kontakt</PanelHeader>
                    <ContextButtonRYS :menu-items="tempContextMenu" :object="contact" @select="contextAction"></ContextButtonRYS>
                </div>
                <div style="display: flex">
                    <div style="width:100%"><PropertyRow :value="contact.lastname">Name</PropertyRow></div>
                    <div style="width: 20px; height: 20px; padding: 0px 3px 0 8px;"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import EditablePropertyRow from "./bricks/EditablePropertyRow";
    import EditableOptionsRow from "./bricks/EditableOptionsRow";
    import PropertyRow from "./bricks/PropertyRow";
    import FormTextRow from "./bricks/FormTextRow";
    import PanelHeader from "./bricks/PanelHeader";
    import ContextButtonRYS from "./bricks/ContextButtonRYS";
    import ConnectionsFormPanel from "./ConnectionsFormPanel";
    import RemarksFormPanel from "./RemarksFormPanel";
    import EditableRowContainer from "./bricks/EditableRowContainer";
    import Utils from "../Utils";

    export default {
        name: "AccountContacts",
        components: {
            EditableRowContainer,
            EditableOptionsRow,
            RemarksFormPanel,
            ContextButtonRYS,
            EditablePropertyRow,
            PropertyRow,
            FormTextRow,
            PanelHeader,
            ConnectionsFormPanel,
        },
        props: {
            model: null,
            height: 500,
        },
        data () {
            return {
                contact: {
                    titel: '',
                    firstname: '',
                    lastname: '',
                    gender: '',
                    department: '',
                    position: '',
                },
                // newForm: false,
                // newButtonText: 'Neuer Kontakt',
                formMessage: '',
                tempContextMenu: [
                    {id:1,
                        code: 1,
                        safe: true,
                        text:'In regulären Kontakt umwandeln ...'},
                    {id:2,
                        code: 2,
                        safe: true,
                        text:'Löschen ...'}
                        ],
                regularContextMenu: [
                    {id:1,
                        code: 2,
                        safe: true,
                        text:'Löschen ...'}
                        ],
                onDelete: false,
                genderItems: [
                    {id: 'm', name: 'männlich'},
                    {id: 'w', name: 'weiblich'},
                    {id: 'd', name: 'nicht angegeben'}
                ],
            }
        },
        methods: {
            contextAction(item, contact) {
                if(item.code === 1) { // convert
                    const account = {};
                    account.contact = {
                        id: contact.id,
                        is_adhoc: false,
                    };
                    this.$emit('updateAdhoc', account);
                } else if (item.code === 2) { // delete
                    this.$emit('deleteContact', contact.id);
                }
            },
            updateTitle (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    title: value,
                };
                this.$emit('updateContact', account);
            },
            updateFirstname (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    firstname: value,
                };
                this.$emit('updateContact', account);
            },
            updateLastname (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    lastname: value,
                };
                this.$emit('updateContact', account);
            },
            updateGender (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    gender: value.id,
                };
                this.$emit('updateContact', account);
            },
            updateDepartment (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    department: value,
                };
                this.$emit('updateContact', account);
            },
            updatePosition (id, value) {
                const account = {};
                account.contact = {
                    id: id,
                    position: value,
                };
                this.$emit('updateContact', account);
            },
            contactName (contact) {
                return Utils.notEmptyConcatReplace([contact.title, ' ', contact.lastname, ', ', contact.firstname], ['[Titel]', ' ', '[Nachname]', ', ', '[Vorname]']);
            },
            contactPosition (contact) {
                return Utils.notEmptyConcatReplace(['als ', contact.position, ' in ', contact.department], ['als ', '[Position]', ' in ', '[Abteilung]']);
            }
        },
        watch: {
            connections () {
            },
            model () {
            },
        },
        mounted () {
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
