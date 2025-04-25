<template>
    <div class="overflow-x-auto">
        <input
            v-model="search"
            type="text"
            placeholder="Search..."
            class="mb-4 p-2 border rounded w-full max-w-xs"
        />

        <table class="min-w-full divide-y divide-gray-200 rounded shadow">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th
                        v-for="(header, index) in headers"
                        :key="index"
                        class="px-4 py-2 font-semibold text-sm text-gray-700 uppercase tracking-wider cursor-pointer"
                        @click="sortBy(index)"
                    >
                        {{ header.text }}
                        <span v-if="sortColumn === index">
                            {{ sortDirection === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(row, rowIndex) in paginatedRows"
                    :key="rowIndex"
                    :class="rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50'"
                    class="hover:bg-blue-50 transition"
                >
                    <td
                        v-for="(col, colIndex) in row"
                        :key="colIndex"
                        class="px-4 py-2 text-sm text-gray-800"
                    >
                        {{ col }}
                    </td>
                </tr>
                <tr v-if="filteredRows.length === 0">
                    <td
                        :colspan="headers.length"
                        class="text-center text-gray-400 py-4 italic"
                    >
                        No data available.
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-between items-center mt-4">
            <button
                @click="prevPage"
                :disabled="currentPage === 1"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded disabled:opacity-50"
            >
                Prev
            </button>
            <span class="text-sm text-gray-600">
                Page {{ currentPage }} of {{ totalPages }}
            </span>
            <button
                @click="nextPage"
                :disabled="currentPage === totalPages"
                class="px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded disabled:opacity-50"
            >
                Next
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
    headers: Array,
    rows: Array,
});

const search = ref("");
const currentPage = ref(1);
const rowsPerPage = 5;
const sortColumn = ref(null);
const sortDirection = ref("asc");

const filteredRows = computed(() => {
    if (!search.value) return props.rows;
    return props.rows.filter((row) =>
        Object.values(row).some((cell) =>
            String(cell).toLowerCase().includes(search.value.toLowerCase())
        )
    );
});

const sortedRows = computed(() => {
    if (sortColumn.value === null) return filteredRows.value;
    return [...filteredRows.value].sort((a, b) => {
        const result = a[sortColumn.value] > b[sortColumn.value] ? 1 : -1;
        return sortDirection.value === "asc" ? result : -result;
    });
});

const totalPages = computed(() =>
    Math.ceil(sortedRows.value.length / rowsPerPage)
);

const paginatedRows = computed(() => {
    const start = (currentPage.value - 1) * rowsPerPage;
    return sortedRows.value.slice(start, start + rowsPerPage);
});

function sortBy(index) {
    if (sortColumn.value === index) {
        sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
    } else {
        sortColumn.value = index;
        sortDirection.value = "asc";
    }
}

function prevPage() {
    if (currentPage.value > 1) currentPage.value--;
}

function nextPage() {
    if (currentPage.value < totalPages.value) currentPage.value++;
}
</script>

<style scoped>
table thead th {
    user-select: none;
}
</style>
