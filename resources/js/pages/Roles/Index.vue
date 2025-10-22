<template>

    <Head title="Roles" />
    <div class="p-10">
        <h1 class="text-3xl font-bold">Roles</h1>
        <Table :headers="currentHeaders" :rows="currentRows" v-if="currentHeaders.length" />
    </div>
</template>

<script setup>
import Table from "@/Components/Table.vue";
import { ref } from "vue";

const currentHeaders = ref([]);
const currentRows = ref([]);
const tableSets = {
    headers: ["Role Name", "Description", "Created At"],
    rows: [
        ["Admin", "Administrator with full access", "2023-01-15"],
        ["Editor", "Can edit content but cannot manage users", "2023-02-10"],
        ["Viewer", "Read-only access to content", "2023-03-05"],
        ["Contributor", "Can contribute content but requires approval", "2023-04-20"],
    ],
};

currentHeaders.value = tableSets.headers;
currentRows.value = tableSets.rows;
</script>

<style lang="scss" scoped></style>