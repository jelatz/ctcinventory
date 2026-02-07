<script setup>
import Offcanvas from '@/Components/Offcanvas.vue'
import FormInput from '@/Components/FormInput.vue'
import Table from '@/Components/Table.vue'
import { ref, h, computed } from 'vue'
import { Eye } from 'lucide-vue-next'
import { useConfirm } from '@/composables/useConfirm'

const confirm = useConfirm()

// Offcanvas state
const showOffcanvas = ref(false)
const mode = ref('add')
const selectedMovement = ref(null)

// Movement types for inventory
const movementTypes = ['Check-out', 'Check-in', 'Transfer', 'Return', 'Maintenance', 'Disposal']
const movementStatuses = ['Pending', 'Approved', 'Completed', 'Cancelled']

// Sample movements data
const movements = ref([
    {
        id: 1,
        datetime: '2024-02-07 10:30 AM',
        asset_tag: 'AST-001',
        asset_name: 'MacBook Pro 16"',
        movement_type: 'Check-out',
        from_location: 'Storage Room A',
        to_location: 'Office 301',
        assigned_to: 'John Doe',
        requested_by: 'Jane Smith',
        status: 'Completed',
        notes: 'Regular assignment'
    },
    {
        id: 2,
        datetime: '2024-02-07 02:15 PM',
        asset_tag: 'AST-002',
        asset_name: 'Dell UltraSharp 27"',
        movement_type: 'Transfer',
        from_location: 'Office 301',
        to_location: 'Office 205',
        assigned_to: 'Mike Johnson',
        requested_by: 'Admin',
        status: 'Pending',
        notes: 'Department transfer'
    },
    {
        id: 3,
        datetime: '2024-02-06 09:00 AM',
        asset_tag: 'AST-003',
        asset_name: 'HP Laptop',
        movement_type: 'Maintenance',
        from_location: 'Office 102',
        to_location: 'IT Department',
        assigned_to: 'IT Support',
        requested_by: 'Sarah Lee',
        status: 'Approved',
        notes: 'Screen repair needed'
    }
])

// Form state
const form = ref({
    asset_tag: '',
    movement_type: '',
    from_location: '',
    to_location: '',
    assigned_to: '',
    requested_by: '',
    status: 'Pending',
    notes: ''
})

// Filters
const filters = ref({
    dateFrom: '',
    dateTo: '',
    asset: '',
    type: '',
    status: ''
})

// Table columns
const columns = [
    {
        accessorKey: 'datetime',
        header: 'Date/Time',
        cell: ({ row }) => {
            return h('span', { class: 'text-sm text-slate-600' }, row.original.datetime)
        }
    },
    {
        accessorKey: 'asset_tag',
        header: 'Asset',
        cell: ({ row }) => {
            return h('div', { class: 'flex flex-col' }, [
                h('span', { class: 'font-semibold text-slate-800' }, row.original.asset_tag),
                h('span', { class: 'text-xs text-slate-500' }, row.original.asset_name)
            ])
        }
    },
    {
        accessorKey: 'movement_type',
        header: 'Type',
        cell: ({ row }) => {
            const type = row.original.movement_type
            const typeColors = {
                'Check-out': 'bg-blue-100 text-blue-800',
                'Check-in': 'bg-green-100 text-green-800',
                'Transfer': 'bg-purple-100 text-purple-800',
                'Return': 'bg-teal-100 text-teal-800',
                'Maintenance': 'bg-yellow-100 text-yellow-800',
                'Disposal': 'bg-red-100 text-red-800'
            }
            return h('span', {
                class: `px-2 py-1 rounded-full text-xs font-semibold ${typeColors[type] || 'bg-gray-100 text-gray-800'}`
            }, type)
        }
    },
    {
        accessorKey: 'from_location',
        header: 'From',
        cell: ({ row }) => h('span', { class: 'text-sm' }, row.original.from_location)
    },
    {
        accessorKey: 'to_location',
        header: 'To',
        cell: ({ row }) => h('span', { class: 'text-sm' }, row.original.to_location)
    },
    {
        accessorKey: 'assigned_to',
        header: 'Assigned To',
        cell: ({ row }) => h('span', { class: 'text-sm' }, row.original.assigned_to)
    },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.original.status
            const statusColors = {
                'Pending': 'bg-yellow-100 text-yellow-800',
                'Approved': 'bg-blue-100 text-blue-800',
                'Completed': 'bg-green-100 text-green-800',
                'Cancelled': 'bg-red-100 text-red-800'
            }
            return h('span', {
                class: `px-2 py-1 rounded-full text-xs font-semibold ${statusColors[status] || 'bg-gray-100 text-gray-800'}`
            }, status)
        }
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            return h('div', { class: 'flex gap-3' }, [
                h(Eye, {
                    class: 'w-5 h-5 cursor-pointer text-slate-600 hover:text-slate-800',
                    onClick: () => viewMovement(row.original)
                })
            ])
        }
    }
]

// Open Offcanvas for Add or View
const openOffcanvas = (action, movement = null) => {
    mode.value = action
    selectedMovement.value = movement
    form.value = movement
        ? { ...movement }
        : {
            asset_tag: '',
            movement_type: '',
            from_location: '',
            to_location: '',
            assigned_to: '',
            requested_by: '',
            status: 'Pending',
            notes: ''
        }
    showOffcanvas.value = true
}

// View movement details
const viewMovement = (movement) => {
    openOffcanvas('view', movement)
}

// Close Offcanvas
const closeOffcanvas = () => {
    showOffcanvas.value = false
}

// Submit new movement
const submitMovement = () => {
    if (mode.value === 'add') {
        const newMovement = {
            id: movements.value.length + 1,
            datetime: new Date().toLocaleString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            }),
            asset_name: 'Asset Name', // This would come from asset lookup
            ...form.value
        }
        movements.value.unshift(newMovement)
    }
    closeOffcanvas()
}

// Export movements
const exportMovements = () => {
    console.log('Exporting movements...')
    // Implementation for export functionality
}
</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Asset Movements</h1>
        </div>

        <div class="flex justify-end w-fit ml-auto space-x-3">
            <button @click="exportMovements"
                class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all">
                Export
            </button>
            <button @click="openOffcanvas('add')"
                class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all">
                New Movement
            </button>
        </div>

        <!-- Filters -->
        <div class="my-8 grid grid-cols-5 gap-x-5">
            <FormInput type="date" label="Date From" v-model="filters.dateFrom" />
            <FormInput type="date" label="Date To" v-model="filters.dateTo" />
            <FormInput type="select" label="Asset" placeholder="All Assets" v-model="filters.asset"
                :options="['AST-001', 'AST-002', 'AST-003']" />
            <FormInput type="select" label="Movement Type" placeholder="All Types" v-model="filters.type"
                :options="movementTypes" />
            <FormInput type="select" label="Status" placeholder="All Statuses" v-model="filters.status"
                :options="movementStatuses" />
        </div>

        <!-- Movements Table -->
        <Table :columns="columns" :data="movements" :total-row-count="movements.length" />

        <!-- Offcanvas for New Movement / View Details -->
        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">
                    {{ mode === 'add' ? 'New Movement' : 'Movement Details' }}
                </h2>

                <div class="space-y-4">
                    <FormInput type="select" label="Asset" placeholder="Select Asset" v-model="form.asset_tag"
                        :options="['AST-001 - MacBook Pro', 'AST-002 - Dell Monitor', 'AST-003 - HP Laptop']"
                        :disabled="mode === 'view'" required />

                    <FormInput type="select" label="Movement Type" placeholder="Select Type"
                        v-model="form.movement_type" :options="movementTypes" :disabled="mode === 'view'" required />

                    <FormInput type="text" label="From Location" placeholder="e.g. Storage Room A"
                        v-model="form.from_location" :disabled="mode === 'view'" required />

                    <FormInput type="text" label="To Location" placeholder="e.g. Office 301" v-model="form.to_location"
                        :disabled="mode === 'view'" required />

                    <FormInput type="text" label="Assigned To" placeholder="Employee Name" v-model="form.assigned_to"
                        :disabled="mode === 'view'" required />

                    <FormInput type="text" label="Requested By" placeholder="Requester Name" v-model="form.requested_by"
                        :disabled="mode === 'view'" required />

                    <FormInput type="select" label="Status" v-model="form.status" :options="movementStatuses"
                        :disabled="mode === 'view'" required />

                    <FormInput type="textarea" label="Notes" placeholder="Additional notes..." v-model="form.notes"
                        :disabled="mode === 'view'" />
                </div>

                <div class="w-full mt-8" v-if="mode === 'add'">
                    <FormInput type="button" label="Create Movement" @click="submitMovement" />
                </div>
            </div>
        </Offcanvas>
    </div>
</template>

<style lang="css" scoped></style>