<template>
    <div>
        <h3>Besuchsbericht erstellen</h3>
        <div id="next-contacts">
            <CommunicationContent :model="model"></CommunicationContent>
        </div>
    </div>
</template>

<script>
    import TextRow from "./bricks/TextRow";
    import FormTextRow from "./bricks/FormTextRow";
    import FormCheckboxRow from "./bricks/FormCheckboxRow";
    import FormValidationRow from "./bricks/FormValidationRow";
    import CommunicationContent from "./CreateCommunicationContent";
    export default {
        name: "CreateCommunication",
        components: {
            CommunicationContent,
            TextRow,
            FormTextRow,
            FormCheckboxRow,
            FormValidationRow,
        },
        data () {
            return {
                model: {}
            }
        },
        methods: {
            clearForm () {
                this.$router.push('/browseAccounts/account').catch(() => {}); // consume exception ("uncaught exception: Object")
            },
        },
        mounted () {
        }
    }
</script>

<style scoped>
    #next-contacts {
        display: grid;
        grid-template-columns: 3fr 2fr;
        grid-gap: 10px;
    }
</style>
