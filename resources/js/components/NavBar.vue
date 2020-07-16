<template>
    <div style="max-height: inherit">
        <router-link to="/browseAccounts">
            <h4 class="nav-item">Kunden</h4>
        </router-link>
        <router-link to="/createCommunication">
            <h4 class="nav-item">Bericht erstellen</h4>
        </router-link>
        <router-link to="/nextContacts">
            <h4 class="nav-item">Kontakte</h4>
        </router-link>
        <router-link to="/manageUsers">
            <h4 class="nav-item">Benutzer</h4>
        </router-link>
        <router-link to="/auxData">
            <h4 class="nav-item">Erweiterte Daten</h4>
        </router-link>
        <router-link to="/changePassword">
            <h4 class="nav-item">Passwort ändern</h4>
        </router-link>
    </div>
</template>

<script>
    export default {
        name: "NavBar"
    }
</script>

<style lang="sass" scoped>

</style>
