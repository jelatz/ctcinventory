<script setup>
import { ref, computed, watch } from 'vue'
import {
    useVueTable,
    getCoreRowModel,
    FlexRender,
} from '@tanstack/vue-table'
import { ArrowLeft, ArrowRight, ArrowUp, ArrowDown } from 'lucide-vue-next'

const props = defineProps({
    columns: {
        type: Array,
        required: true
    },
    // Data is now the current page's data from the server
    data: {
        type: Array || Object || Function,
        required: true
    },
    // New prop: Total number of items in the database (required for pagination)
    totalRowCount: {
        type: Number,
        required: true
    },
    // New prop: Loading state
    isLoading: {
        type: Boolean,
        default: false
    }
})

// --- 1. Reactive State for Server-Side Operations (Controlled State) ---
const sorting = ref([])
const globalFilter = ref('')
const pagination = ref({
    pageIndex: 0,
    pageSize: 10,
})

const emit = defineEmits(['update:serverState'])

// --- 2. TanStack Table Configuration (Manual Mode) ---
const table = useVueTable({
    get data() {
        return props.data
    },
    get columns() {
        return props.columns
    },
    getCoreRowModel: getCoreRowModel(),

    // --- Crucial for Server-Side: Manual Mode ---
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,

    // Total number of rows for pagination display
    rowCount: computed(() => props.totalRowCount).value,

    // --- Controlled State Configuration ---
    state: {
        get sorting() {
            return sorting.value
        },
        get globalFilter() {
            return globalFilter.value
        },
        get pagination() {
            return pagination.value
        },
    },

    // State Change Handlers
    onSortingChange: (updater) => {
        sorting.value = typeof updater === 'function' ? updater(sorting.value) : updater
        // Reset to first page on sort change
        pagination.value.pageIndex = 0
    },
    onGlobalFilterChange: (updater) => {
        globalFilter.value = typeof updater === 'function' ? updater(globalFilter.value) : updater
        // Reset to first page on filter change
        pagination.value.pageIndex = 0
    },
    onPaginationChange: (updater) => {
        pagination.value = typeof updater === 'function' ? updater(pagination.value) : updater
    },
})

// --- 3. Watcher to Emit Server State Changes ---
const serverState = computed(() => ({
    pageIndex: pagination.value.pageIndex,
    pageSize: pagination.value.pageSize,
    sorting: sorting.value,
    globalFilter: globalFilter.value,
}))

// Emit the state changes to the parent component for data fetching
watch(serverState, (newState) => {
    // This will trigger the parent component to fetch new data
    emit('update:serverState', newState)
}, { deep: true, immediate: true }) // immediate: true ensures initial load

// --- 4. Helper Functions ---
// Helper to update page size from a select input
function handlePageSizeChange(event) {
    table.setPageSize(Number(event.target.value))
}

// --- 5. Computed Properties for Pagination Info ---
const currentPage = computed(() => table.getState().pagination.pageIndex + 1)
const pageSize = computed(() => table.getState().pagination.pageSize)
const totalFilteredRows = computed(() => props.totalRowCount) // Use prop for server-side total
const startItem = computed(() => (currentPage.value - 1) * pageSize.value + 1)
const endItem = computed(() => Math.min(currentPage.value * pageSize.value, totalFilteredRows.value))
</script>

<template>
    <div class="overflow-x-auto block">
        <div class="flex justify-between items-center mb-4">
            <!-- Per Page Selector -->
            <select name="select" id="limit" :value="pageSize" @change="handlePageSizeChange"
                class="border border-gray-300 rounded px-2 py-1">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>

            <!-- Search Input -->
            <input type="text" :value="globalFilter" @input="table.setGlobalFilter($event.target.value)"
                class="border border-gray-300 rounded px-2 py-1 min-w-96" placeholder="Search..." />
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <th v-for="header in headerGroup.headers" :key="header.id" class="text-left px-3 py-3 border-b"
                        :class="{ 'cursor-pointer select-none': header.column.getCanSort() }"
                        @click="header.column.getToggleSortingHandler()?.($event)">
                        <div class="flex items-center">
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                                :props="header.getContext()" />

                            <!-- Sorting Indicator Logic -->
                            <span class="ml-2">
                                <ArrowUp v-if="header.column.getIsSorted() === 'asc'" class="w-4 h-4" />
                                <ArrowDown v-else-if="header.column.getIsSorted() === 'desc'" class="w-4 h-4" />
                            </span>
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody>
                <!-- Loading State -->
                <tr v-if="isLoading">
                    <td :colspan="columns.length" class="text-center py-10 text-gray-500">
                        <div class="flex justify-center items-center space-x-2">
                            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>Loading data...</span>
                        </div>
                    </td>
                </tr>

                <!-- Data Rows -->
                <tr v-else v-for="row in table.getRowModel().rows" :key="row.id" class="hover:bg-gray-50">
                    <td v-for="cell in row.getVisibleCells()" :key="cell.id" class="px-3 py-3 border-b">
                        <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                    </td>
                </tr>

                <!-- No Records Found State -->
                <tr v-if="!isLoading && !props.data.length">
                    <td :colspan="columns.length" class="text-center py-4 text-gray-500">
                        No records found
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="mt-10 flex items-center justify-between">
            <div class="flex gap-5">
                <p>
                    Showing {{ startItem }} to {{ endItem }} of {{ totalFilteredRows }} results
                </p>
                <p>Page {{ currentPage }} of {{ table.getPageCount() }}</p>
            </div>
            <div class="flex gap-5">
                <button @click="table.previousPage()" :disabled="!table.getCanPreviousPage()"
                    class="flex items-center gap-2 disabled:opacity-50">
                    <ArrowLeft class="w-5 h-5" />Previous
                </button>
                <button @click="table.nextPage()" :disabled="!table.getCanNextPage()"
                    class="flex items-center gap-2 disabled:opacity-50">
                    Next
                    <ArrowRight class="w-5 h-5" />
                </button>
            </div>
        </div>
    </div>
</template>
