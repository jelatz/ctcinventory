<template>
    <div>
        <div class="p-10">
            <div class="p-10">
                <div class="flex items-center justify-start space-x-5">
                    <button
                        class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                        @click="itemModal = true"
                    >
                        Add Item
                    </button>
                    <!-- User Modal -->
                    <Modal
                        :isOpen="itemModal"
                        @close="itemModal = false"
                        modalSize="w-1/2"
                    >
                        <h2 class="text-xl font-semibold mb-4">Add Item</h2>
                    </Modal>
                </div>
                <label
                    for="category-select"
                    class="block mt-5 font-medium text-gray-700"
                >
                    Category
                </label>
                <v-select
                    :options="categoryOptions"
                    label="category"
                    :reduce="(category) => category.code"
                    multiple
                    placeholder="Select category"
                    class="w-96"
                    id="category-select"
                />
                <Table :headers="currentHeaders" :rows="currentRows" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";
import Table from "@/Components/Table.vue";

// State variables
const itemModal = ref(false);

const categoryOptions = [
    { category: "Devices", code: "1" },
    { category: "Supply", code: "2" },
    { category: "Tools", code: "3" },
    { category: "Furnitures", code: "4" },
    { category: "Others", code: "5" },
];

// Table data
const tableSets = {
    totalItems: {
        headers: ["Employee ID", "Name", "Position", "Department", "Action"],
        rows: [
            ["E001", "John Doe", "Software Engineer", "IT", "Edit"],
            ["E002", "Jane Smith", "Project Manager", "Marketing", "Edit"],
            ["E003", "Sam Wilson", "Data Analyst", "Finance", "Edit"],
            ["E004", "Lisa Brown", "UX Designer", "Design", "Edit"],
            ["E005", "Tom Green", "Sales Executive", "Sales", "Edit"],
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
