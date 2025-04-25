<template>
    <div class="overflow-x-auto mt-5 w-full">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <label for="pages" class="mr-2">Show:</label>
                <select
                    name="pages"
                    id="pages"
                    class="rounded-md border px-2 py-1"
                >
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="all">All</option>
                </select>
                <p class="inline-block ml-2">Entries</p>
            </div>
            <div>
                <input
                    type="text"
                    placeholder="Search..."
                    class="rounded-md border px-2 py-1 ml-4"
                />
            </div>
        </div>
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th
                        v-for="(header, headerIndex) in headers"
                        :key="headerIndex"
                        class="text-left px-4 py-2 border-b"
                    >
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(row, rowIndex) in rows"
                    :key="rowIndex"
                    class="even:bg-gray-100"
                >
                    <td
                        v-for="(value, colIndex) in row"
                        :key="colIndex"
                        class="px-4 py-2 border-b"
                    >
                        {{ value }}
                    </td>
                </tr>
            </tbody>
        </table>
        <button
            class="block mt-4 ml-auto px-4 py-2 rounded-lg bg-blue-950 text-white cursor-pointer hover:bg-blue-900"
            @click="showModal = true"
        >
            Add User
        </button>
        <Modal :isOpen="showModal" @close="showModal = false" modalSize="w-1/2">
            <h2 class="text-xl font-semibold mb-4">Add User</h2>
        </Modal>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Modal from "@/Components/Modal.vue";

const showModal = ref(false);

defineProps({
    headers: Array,
    rows: Array,
});
</script>

<!-- v-model="selectedPageSize"
@change="updatePagination" -->
