<template>
    <div>
        <div class="p-10">
            <h1 class="text-2xl font-bold mb-5">Items</h1>
            <div class="flex items-center justify-start space-x-5">
                <button class="px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                    @click="itemModal = true">
                    Add Item
                </button>
                <!-- Item Modal -->
                <Modal :isOpen="itemModal" @close="itemModal = false" modalSize="w-3/4">
                    <h2 class="text-xl font-semibold mb-4">Add Item</h2>
                    <form>
                        <div class="flex items-center justify-between gap-5 flex-wrap mt-10">
                            <FormInput formLabel="Item Name" labelFor="item" formInputType="input" v-model="item"
                                inputClass="w-full" :formError="false" errorMessage="Please enter a brand"
                                containerClass="w-60" />
                            <FormInput formLabel="Item Code" labelFor="itemCode" formInputType="input"
                                v-model="itemCode" inputClass="w-full" :formError="false"
                                errorMessage="Please enter a brand" containerClass="w-60" />
                            <FormInput formLabel="Serial Number" labelFor="serialNumber" formInputType="input"
                                inputType="text" v-model="serialNumber" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Model" labelFor="model" formInputType="input" inputType="text"
                                v-model="model" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Warranty Due" labelFor="warrantyDue" formInputType="input"
                                inputType="text" v-model="warrantyDue" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Shelf Life" labelFor="shelfLife" formInputType="input"
                                inputType="text" v-model="shelfLife" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Brand" labelFor="brand" formInputType="input" inputType="text"
                                v-model="brand" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                            <FormInput formLabel="Supplier" labelFor="supplier" formInputType="input" inputType="text"
                                v-model="supplier" inputClass="w-full" :formError="false"
                                errorMessage="This field is required" containerClass="w-60" />
                        </div>

                        <button type="submit"
                            class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                            Add
                        </button>
                    </form>
                </Modal>
            </div>
            <label for="category-select" class="block mt-5 font-medium text-gray-700">
                Category
            </label>
            <v-select :options="categoryOptions" label="category" :reduce="(category) => category.code" multiple
                placeholder="Select category" class="w-96" id="category-select" />
            <Table :headers="currentHeaders" :rows="currentRows" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import FormInput from "@/Components/Form/FormInput.vue";
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

// hide modal on escape key press
document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        itemModal.value = false;
    }
})
</script>

<style scoped></style>
