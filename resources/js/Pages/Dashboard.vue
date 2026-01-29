<script setup>
import { onMounted, ref, watch } from 'vue'
import { useToast } from '@/Composables/useToast'
import Cards from '@/Components/Cards.vue'
import { Home, Users, Boxes, Files, ArrowLeftRight, Laptop, Monitor } from 'lucide-vue-next'
import Table from '@/Components/Table.vue' // This should be the ServerSideTanStackTable component

import Toast from '@/Components/Toast.vue'
const { add } = useToast()

const cards = [
    {
        id: 1,
        title: 'Laptops',
        unassignedValue: '10',
        inRepairValue: '10',
        assignedValue: '100',
        totalValue: '200',
        icon: Laptop,
    },
    {
        id: 2,
        title: 'Monitors',
        assignedValue: '100',
        icon: Monitor,
        totalValue: '100',
        unassignedValue: '10',
        inRepairValue: '10',
    },
    {
        id: 3,
        title: 'Peripherals',
        assignedValue: '200',
        totalValue: '150',
        unassignedValue: '10',
        inRepairValue: '10',
        icon: ArrowLeftRight,
    },
]

// --- Server-Side Table State ---
const currentColumns = ref([])
const currentData = ref([])
const totalRowCount = ref(0)
const isLoading = ref(false)
const selectedCategory = ref('Laptops')

// This object holds the current state of the table (page, sort, filter)
const serverState = ref({
    pageIndex: 0,
    pageSize: 10,
    sorting: [],
    globalFilter: '',
})

// Column definitions (Moved from static object to a function or reactive logic)
const getColumnsForCategory = (category) => {
    const columnMap = {
        'Laptops': [
            { header: 'Brand', accessorKey: 'brand' },
            { header: 'Model', accessorKey: 'model' },
            { header: 'Serial Number', accessorKey: 'serial' },
            { header: 'Status', accessorKey: 'status' },
        ],
        'Monitors': [
            { header: 'Brand', accessorKey: 'brand' },
            { header: 'Size', accessorKey: 'size' },
            { header: 'Serial Number', accessorKey: 'serial' },
            { header: 'Status', accessorKey: 'status' },
        ],
        'Peripherals': [
            { header: 'Type', accessorKey: 'type' },
            { header: 'Brand', accessorKey: 'brand' },
            { header: 'Model', accessorKey: 'model' },
            { header: 'Status', accessorKey: 'status' },
        ]
    }
    return columnMap[category] || []
}

// --- Data Fetching Logic ---
const fetchData = async () => {
    isLoading.value = true

    // Prepare your API parameters
    const params = {
        category: selectedCategory.value,
        page: serverState.value.pageIndex + 1,
        limit: serverState.value.pageSize,
        search: serverState.value.globalFilter,
        sort: serverState.value.sorting.map(s => `${s.id}:${s.desc ? 'desc' : 'asc'}`).join(',')
    }

    try {
        console.log('Fetching data from server with params:', params)

        // Replace this with your actual API call (e.g., using axios or Inertia)
        // const response = await axios.get('/api/inventory', { params })
        // currentData.value = response.data.data
        // totalRowCount.value = response.data.total

        // --- MOCK API SIMULATION ---
        await new Promise(resolve => setTimeout(resolve, 600))

        // For demonstration, we'll just use the static data but simulate pagination
        const allData = {
            'Laptops': [
                { brand: 'Dell', model: 'XPS 15', serial: 'CN123456', status: 'Assigned' },
                { brand: 'MacBook', model: 'Pro 14', serial: 'AP789012', status: 'In Repair' },
                { brand: 'Lenovo', model: 'ThinkPad T14', serial: 'LN345678', status: 'Unassigned' },
                { brand: 'Dell', model: 'Latitude 5420', serial: 'DL542099', status: 'Assigned' },
                { brand: 'HP', model: 'EliteBook', serial: 'HP998877', status: 'Assigned' },
                // ... more items
            ],
            'Monitors': [
                { brand: 'Dell', size: '27"', serial: 'DL-M-001', status: 'Assigned' },
                { brand: 'LG', size: '24"', serial: 'LG-M-002', status: 'Unassigned' },
                { brand: 'Samsung', size: '32"', serial: 'SM-CURVED-01', status: 'Assigned' },
            ],
            'Peripherals': [
                { type: 'Mouse', brand: 'Logitech', model: 'MX Master 3', status: 'Assigned' },
                { type: 'Keyboard', brand: 'Keychron', model: 'K2', status: 'Assigned' },
                { type: 'Headset', brand: 'Jabra', model: 'Evolve2', status: 'In Repair' },
            ]
        }

        const categoryData = allData[selectedCategory.value] || []
        currentData.value = categoryData.slice(0, serverState.value.pageSize) // Mock pagination
        totalRowCount.value = categoryData.length * 5 // Mock total count for pagination demo
        // --- END MOCK ---

    } catch (error) {
        console.error('Error fetching inventory:', error)
    } finally {
        isLoading.value = false
    }
}

// --- Event Handlers ---
const selectCategory = (title) => {
    selectedCategory.value = title
    currentColumns.value = getColumnsForCategory(title)
    // Reset table state when switching categories
    serverState.value = {
        ...serverState.value,
        pageIndex: 0,
    }
    fetchData()
}

const handleServerStateUpdate = (newState) => {
    serverState.value = newState
    fetchData()
}

onMounted(() => {
    add('Welcome to Dashboard')
    currentColumns.value = getColumnsForCategory('Laptops')
    fetchData()
})
</script>

<template>
    <div class="p-10">
        <h1 class="text-3xl font-bold">Dashboard</h1>

        <div class="grid grid-cols-4 gap-10 mt-5">
            <Cards v-for="card in cards" :key="card.id" :title="card.title" :assignedValue="card.assignedValue"
                :icon="card.icon" :unassignedValue="card.unassignedValue" :inRepairValue="card.inRepairValue"
                :totalValue="card.totalValue" @click="selectCategory(card.title)"
                class="cursor-pointer transition-all duration-200 hover:scale-105 hover:ring-2 hover:ring-amber-500"
                :class="{ 'ring-2 ring-amber-600 bg-amber-50': selectedCategory === card.title }" />
        </div>

        <div class="mt-20">
            <h2 class="text-xl font-bold mb-4">{{ selectedCategory }} Details</h2>

            <!-- Updated Table with Server-Side Props -->
            <Table :columns="currentColumns" :data="currentData" :total-row-count="totalRowCount"
                :is-loading="isLoading" @update:serverState="handleServerStateUpdate" />
        </div>
    </div>
</template>

<style scoped></style>
