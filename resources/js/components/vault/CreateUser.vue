<template>
    <div id="create-user">
        <div id="form" class="content-floater">
            <h4>Benutzer Eingabe</h4>
            <div>
                <FormTextRow @pushHeight="pushFormRowHeight">Email</FormTextRow>
                <FormTextRow>Anrede</FormTextRow>
                <FormTextRow>Vorname</FormTextRow>
                <FormTextRow>Nachname</FormTextRow>
                <FormTextRow>Kürzel</FormTextRow>
            </div>
            <button style="float: right" class="button green-button">Senden</button>
        </div>
        <div id="validation" class="content-floater">
            <h4>Benutzer Ausgabe</h4>
            <div>
                <FormValidationRow :height="formRowHeight" :isError="true">Email ist erforderlich</FormValidationRow>
                <FormValidationRow :height="formRowHeight" :isError="true">Anrede ist erforderlich</FormValidationRow>
                <FormValidationRow :height="formRowHeight" :isError="true">Vorname ist erforderlich</FormValidationRow>
                <FormValidationRow :height="formRowHeight" :isError="true">Nachname ist erforderlich</FormValidationRow>
                <FormValidationRow :height="formRowHeight" :isError="true">Kürzel ist erforderlich</FormValidationRow>
            </div>
        </div>
    </div>
</template>

<script>
    import FormTextRow from "../bricks/FormTextRow";
    import FormValidationRow from "../bricks/FormValidationRow";
    export default {
        name: "CreateUser",
        components: {
            FormTextRow,
            FormValidationRow
        },
        data () {
            return {
                formRowHeight: 0,
            }
        },
        methods: {
            pushFormRowHeight (event) {
                this.formRowHeight = event;
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>
    #create-user {
        display: grid;
        grid-template-columns: 2fr 1fr 2fr;
        grid-gap: 10px;
    }
</style>
