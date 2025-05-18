<template>
    <div class="p-10">
        <h1 class="text-2xl font-bold mb-5">Item Category</h1>

        <div>
            <button
                class="block mt-4 mr-auto px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
                @click="showModal = true">
                Add Category
            </button>
            <Modal :isOpen="showModal" @close="showModal = false" modalSize="w-1/2">
                <h2 class="text-xl font-semibold mb-4">Add Category</h2>
                <form>
                    <FormInput formLabel="Category Name" labelFor="category" formInputType="input" v-model="category"
                        inputClass="w-full" :formError="false" errorMessage="Please enter a category"
                        containerClass="w-full" />
                    <button type="submit"
                        class="mt-5 px-10 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900 block ml-auto">
                        Add
                    </button>
                </form>
            </Modal>

            <!-- table for the categories -->
            <Table :headers="currentHeaders" :rows="currentRows" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import FormInput from "@/Components/Form/FormInput.vue";
import Table from "@/Components/Table.vue";
import Modal from "@/Components/Modal.vue";

const showModal = ref(false);

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
