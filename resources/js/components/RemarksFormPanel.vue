<template>
    <div class="inside-panel" style="padding-bottom:5px;display:flex">
<!--        <div style="display:flex;justify-content: space-between">-->
<!--            <PanelHeader>Bemerkungen</PanelHeader>-->
<!--            <AddButton @click="add"></AddButton>-->
<!--        </div>-->
        <div style="width:100%">
            <UpdateDeleteRemarkRow
                    v-for="remark in remarks"
                    :key="remark.id"
                    :model="remark"
                    :items="remarkTypes"
                    @createUpdateConfirmed="createUpdate"
                    @deleteConfirmed="$emit('delete', $event)"
                    @createCancelled="createCancelled"
            ></UpdateDeleteRemarkRow>
            <PanelHeader v-if="remarks.length == 0">Bemerkungen</PanelHeader>
        </div>
        <AddButton @click="add"></AddButton>
    </div>
</template>

<script>
    import UpdateDeleteRemarkRow from "./UpdateDeleteRemarkRow";
    import AddButton from "./bricks/AddButton";
    import PanelHeader from "./bricks/PanelHeader";
    import ServiceRequest from "../ServiceRequest";

    export default {
        components: {
            AddButton,
            UpdateDeleteRemarkRow,
            PanelHeader,

        },
        name: "RemarksFormPanel",
        props: {
            model: {},
        },
        data () {
            return {
                remarks: this.model.remarks,
                remarkCreating: null,
                remarkCreatingIndex: null,
                remarkTypes: [],
                service: new ServiceRequest(),
            }
        },
        methods: {
            createUpdate (id, type, data) {
                if (this.remarkCreating) { // save
                    const remark = {
                        parentId: this.model.id,
                        typeId: type.id,
                        data: data,
                    };
                    this.remarks.splice(this.remarkCreatingIndex, 1);
                    this.remarkCreating = null;
                    this.$emit('save', remark);
                } else { // update
                    const remark = {
                        id: id,
                        typeId: type.id,
                        data: data,
                    };
                    this.remarks.splice(this.remarkCreatingIndex, 1);
                    this.remarkCreating = null;
                    this.remarkCreatingIndex = -1;
                    this.$emit('update', remark);
                }
            },
            add () {
                if (this.remarkCreating) {
                    return;
                }
                const maxId = this.remarks.length;
                this.remarkCreatingIndex = maxId;
                this.remarkCreating = {
                    id: this.remarkCreatingIndex,
                    type: this.remarkTypes[0],
                    data: '',
                    create: true,
                };
                this.remarks.push(this.remarkCreating);
            },
            createCancelled () {
                if (this.remarkCreating) {
                    this.remarks.splice(this.remarkCreatingIndex, 1);
                    this.remarkCreating = null;
                    this.remarkCreatingIndex = -1;
                }
            }
        },
        watch: {
            model () {
                this.remarks = this.model.remarks;
            }
        },
        mounted () {
            this.service.url = "json/remark/types";
            this.service.doGet((error, data) => {
                if (error) {
                    console.error('Load RemarkType failed: ' + data);
                } else {
                    this.remarkTypes = data;
                }
            });
        }
    }
</script>

<style scoped>

</style>