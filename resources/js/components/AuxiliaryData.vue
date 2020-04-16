<template>
    <div>
        <h3>Erweiterte Daten</h3>
        <div id="browse-accounts">
            <div class="content-floater">
                <select multiple size="7" style="width:100%" @change="goto($event.target.value)">
                    <option value="addressType">Adresstyp</option>
                    <option value="communicationType">Gesprächsart</option>
                    <option value="sector">Branche</option>
                    <option value="connectionType">Verbindungstyp</option>
                    <option value="remarkType">Bemerkungstyp</option>
                </select>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AuxiliaryData",
        methods: {
            goto (value) {
                if (value) {
                    this.$router.replace('/auxData/'+value);
                }
            },
        },
    }
</script>

<style scoped>
    #browse-accounts {
        display: grid;
        grid-template-columns: 1fr 4fr 2fr;
        grid-gap: 10px;
    }
</style>