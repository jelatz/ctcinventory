<template>
    <div>
        <div class="p-10">
            <Table :headers="currentHeaders" :rows="currentRows" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Table from "@/Components/Table.vue";
const tableSets = {
    totalItems: {
        headers: ["Item Name", "Category", "Status"],
        rows: [
            ["Mouse", "Electronics", "Available"],
            ["Keyboard", "Electronics", "Assigned"],
        ],
    },
};

const currentHeaders = ref([]);
const currentRows = ref([]);

// Initialize on mount
onMounted(() => {
    currentHeaders.value = tableSets.totalItems.headers;
    currentRows.value = tableSets.totalItems.rows;
});
</script>

<style scoped></style>
