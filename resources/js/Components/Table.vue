<template>
    <div class="overflow-x-auto mt-10 w-full">
        <!-- Controls -->
        <div class="mb-4 flex items-center justify-between">
            <div>
                <label for="pages" class="mr-2">Show:</label>
                <select id="pages" class="rounded-md border px-2 py-1" v-model="selectedPageSize" @change="emitUpdate">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <p class="inline-block ml-2">Entries</p>
            </div>
            <div>
                <input type="text" v-model="searchQuery" @input="debouncedSearch" placeholder="Search..."
                    class="rounded-md border px-2 py-1 ml-4" />
            </div>
        </div>

        <!-- Table -->
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th v-for="(header, index) in headers" :key="index" @click="toggleSort(index)"
                        class="text-left px-4 py-2 border-b cursor-pointer select-none">
                        {{ header }}
                        <span v-if="sortColumn === index">
                            {{ sortDirection === "asc" ? "▲" : "▼" }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, rowIndex) in rows" :key="rowIndex" class="even:bg-gray-100">
                    <td v-for="(value, colIndex) in row" :key="colIndex" class="px-4 py-2 border-b">
                        <!-- If parent provides a slot for this column -->
                        <slot :name="headers[colIndex]" :row="row" :value="value" :rowIndex="rowIndex"
                            :colIndex="colIndex">
                            <!-- Fallback: just render text -->
                            {{ value }}
                        </slot>
                    </td>
                </tr>
            </tbody>

        </table>

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4">
            <div>
                Showing
                {{ (currentPage - 1) * selectedPageSize + 1 }}
                to
                {{ Math.min(currentPage * selectedPageSize, totalItems) }}
                of {{ totalItems }} entries
            </div>
            <div class="flex items-center">
                <button @click="prevPage" :disabled="currentPage === 1"
                    class="px-3 py-1 rounded border mr-2 disabled:opacity-50">
                    Previous
                </button>
                <span class="mx-2">Page {{ currentPage }} of {{ totalPages }}</span>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                    class="px-3 py-1 rounded border ml-2 disabled:opacity-50">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import debounce from "lodash/debounce";

const emit = defineEmits(["fetch"]);

const props = defineProps({
    headers: Array,
    rows: Array, // Current page's data only
    totalItems: Number,
});

const currentPage = ref(1);
const selectedPageSize = ref(10);
const searchQuery = ref("");
const sortColumn = ref(null);
const sortDirection = ref("asc");

// Emit params to parent
function emitUpdate() {
    emit("fetch", {
        page: currentPage.value,
        pageSize: selectedPageSize.value,
        search: searchQuery.value,
        sortColumn: sortColumn.value,
        sortDirection: sortDirection.value,
    });
}

// Watchers
watch([selectedPageSize], () => {
    currentPage.value = 1;
    emitUpdate();
});

// Debounced search
const debouncedSearch = debounce(() => {
    currentPage.value = 1;
    emitUpdate();
}, 500);

// Pagination
function prevPage() {
    if (currentPage.value > 1) {
        currentPage.value--;
        emitUpdate();
    }
}
function nextPage() {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
        emitUpdate();
    }
}

// Sorting
function toggleSort(index) {
    if (sortColumn.value === index) {
        sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
    } else {
        sortColumn.value = index;
        sortDirection.value = "asc";
    }
    emitUpdate();
}

// Total pages
const totalPages = computed(() => {
    return Math.ceil(props.totalItems / selectedPageSize.value);
});
</script>
