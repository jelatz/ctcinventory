<template>

    <Head title="Permissions" />
    <div class="p-10">
        <h1 class="text-3xl font-bold">Permissions</h1>
        <Table :headers="currentHeaders" :rows="currentRows" v-if="currentHeaders.length" />
    </div>
</template>

<script setup>
import Table from "@/Components/Table.vue";
import { ref } from "vue";

const currentHeaders = ref([]);
const currentRows = ref([]);
const tableSets = {
    headers: ["Permission Name", "Description", "Created At"],
    rows: [
        ["Create Item", "Allows creation of new items", "2023-01-15"],
        ["Edit Item", "Allows editing of existing items", "2023-02-10"],
        ["Delete Item", "Allows deletion of items", "2023-03-05"],
        ["View Reports", "Allows viewing of reports", "2023-04-20"],
    ],
};

currentHeaders.value = tableSets.headers;
currentRows.value = tableSets.rows;
</script>

<style lang="scss" scoped></style>