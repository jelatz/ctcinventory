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
        <div class="flex justify-between items-center mt-4">
            <div>
                Showing {{ (currentPage - 1) * pageSize + 1 }} to
                {{ Math.min(currentPage * pageSize, totalItems) }} of
                {{ totalItems }} entries
            </div>
            <div class="flex items-center">
                <button
                    @click="prevPage"
                    :disabled="currentPage === 1"
                    class="px-3 py-1 rounded border mr-2 disabled:opacity-50"
                >
                    Previous
                </button>
                <span class="mx-2"
                    >Page {{ currentPage }} of {{ totalPages }}</span
                >
                <button
                    @click="nextPage"
                    :disabled="currentPage === totalPages"
                    class="px-3 py-1 rounded border ml-2 disabled:opacity-50"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    headers: Array,
    rows: Array,
});

const searchQuery = ref("");
const pageSize = ref(10);
const currentPage = ref(1);

const filteredRows = computed(() => {
    if (!searchQuery.value) {
        return props.rows;
    }
    return props.rows.filter((row) =>
        row.some((cell) =>
            String(cell).toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    );
});

const totalItems = computed(() => filteredRows.value.length);

const totalPages = computed(() => {
    if (pageSize.value === "all") {
        return 1;
    }
    return Math.ceil(totalItems.value / pageSize.value);
});

const paginatedRows = computed(() => {
    if (pageSize.value === "all") {
        return filteredRows.value;
    }
    const start = (currentPage.value - 1) * pageSize.value;
    return filteredRows.value.slice(start, start + pageSize.value);
});

function prevPage() {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
}

function nextPage() {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
}

function updatePagination(event) {
    pageSize.value =
        event.target.value === "all" ? "all" : parseInt(event.target.value);
    currentPage.value = 1; // reset to first page after changing page size
}
</script>

<!-- v-model="selectedPageSize"
@change="updatePagination" -->
