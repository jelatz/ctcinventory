<template>
    <div>
        <div class="p-10">
            <div class="p-10">
                <div class="flex items-center justify-start space-x-5">
                    <button
                        class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                        @click="userModal = true"
                    >
                        Add User
                    </button>
                    <!-- User Modal -->
                    <Modal
                        :isOpen="userModal"
                        @close="userModal = false"
                        modalSize="w-1/2"
                    >
                        <h2 class="text-xl font-semibold mb-4">Add User</h2>
                        ``
                    </Modal>
                    <button
                        class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                        @click="positionModal = true"
                    >
                        Add Position
                    </button>
                    <!-- Position Modal -->
                    <Modal
                        :isOpen="positionModal"
                        @close="positionModal = false"
                        modalSize="w-1/2"
                    >
                        <h2 class="text-xl font-semibold mb-4">Add Position</h2>
                        ``
                    </Modal>
                    <button
                        class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                        @click="departmentModal = true"
                    >
                        Add Department
                    </button>
                    <!-- Department Modal -->
                    <Modal
                        :isOpen="departmentModal"
                        @close="departmentModal = false"
                        modalSize="w-1/2"
                    >
                        <h2 class="text-xl font-semibold mb-4">
                            Add Department
                        </h2>
                        ``
                    </Modal>
                </div>
                <Modal
                    :isOpen="showModal"
                    @close="showModal = false"
                    modalSize="w-1/2"
                >
                    <h2 class="text-xl font-semibold mb-4">Add User</h2>
                    ``
                </Modal>
                <Table :headers="currentHeaders" :rows="currentRows" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Modal from "@/Components/Modal.vue";

const userModal = ref(false);
const positionModal = ref(false);
const departmentModal = ref(false);
import Table from "@/Components/Table.vue";
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
