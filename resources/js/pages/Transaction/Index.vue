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


// Table data
const tableSets = {
    totalItems: {
        headers: ["Transaction ID", "Item Name", "Quantity", "Date", "Type", "Action"],
        rows: [
            ["T001", "Laptop", "2", "2023-06-15", "Completed", "View"],
            ["T002", "Monitor", "5", "2023-06-16", "Pending", "View"],
            ["T003", "Keyboard", "10", "2023-06-17", "Completed", "View"],
            ["T004", "Mouse", "15", "2023-06-18", "Cancelled", "View"],
            ["T005", "Headset", "7", "2023-06-19", "Processing", "View"],
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
