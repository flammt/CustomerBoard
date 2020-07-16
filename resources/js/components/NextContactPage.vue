<template>
    <div id="form" class="content-floater" :style="'max-height: '+height+'px;overflow-y: auto'">
        <NextContact v-for="account in pageAccounts" :key="account.communication_id" :model="account" @dateChanged="$emit('dateChanged', $event)"></NextContact>
    </div>
</template>

<script>
    import NextContact from "./NextContact";

    export default {
        name: "NextContactPage",
        components: {
            NextContact
        },
        props: {
            accounts: null,
            page: null,
            height: null
        },
        data () {
            return {
                pageAccounts: null
            }
        },
        computed: {
        },
        watch: {
            page () {
                this.pageAccounts = this.accounts ? this.accounts[this.page-1] : null
            },
            accounts () {
                this.pageAccounts = this.accounts[this.page-1]
            }
        }
    }
</script>

<style scoped>

</style>
