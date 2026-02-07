<script setup>
import Offcanvas from '@/Components/Offcanvas.vue'
import { ref, h } from 'vue'
import Table from '@/Components/Table.vue'
import { SquarePen, Trash2 } from 'lucide-vue-next'
import { useConfirm } from '@/composables/useConfirm'
import FormInput from '@/Components/FormInput.vue'

const confirm = useConfirm()

// Offcanvas state
const showOffcanvas = ref(false)
const mode = ref('add') // 'add' or 'edit'
const selectedAsset = ref(null)

// Assets table data
const assets = ref([
    { asset_tag: 'AST-001', name: 'MacBook Pro 16"', category: 'Laptop', status: 'Available', serial_number: 'C02...', purchase_date: '2023-01-15', cost: 2500 },
    { asset_tag: 'AST-002', name: 'Dell UltraSharp 27"', category: 'Monitor', status: 'In Use', serial_number: 'CN-0...', purchase_date: '2023-02-10', cost: 450 }
])

// Form state
const form = ref({
    asset_tag: '',
    name: '',
    category: '',
    status: 'Available',
    serial_number: '',
    purchase_date: '',
    cost: ''
})

// Table columns
const columns = [
    { accessorKey: 'asset_tag', header: 'Asset Tag' },
    { accessorKey: 'name', header: 'Name' },
    { accessorKey: 'category', header: 'Category' },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.original.status
            const colors = {
                'Available': 'bg-green-100 text-green-800',
                'In Use': 'bg-blue-100 text-blue-800',
                'Defective': 'bg-red-100 text-red-800',
                'Maintenance': 'bg-yellow-100 text-yellow-800'
            }
            return h('span', { class: `px-2 py-1 rounded-full text-xs font-semibold ${colors[status] || 'bg-gray-100 text-gray-800'}` }, status)
        }
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            return h('div', { class: 'flex gap-3' }, [
                h(SquarePen, {
                    class: 'w-5 h-5 cursor-pointer text-blue-600 hover:text-blue-800',
                    onClick: () => openOffcanvas('edit', row.original)
                }),
                h(Trash2, {
                    class: 'w-5 h-5 cursor-pointer text-red-600 hover:text-red-800',
                    onClick: () => deleteAsset(row.original)
                })
            ])
        }
    }
]

// Open Offcanvas for Add or Edit
const openOffcanvas = (action, asset = null) => {
    mode.value = action
    selectedAsset.value = asset
    form.value = asset
        ? { ...asset } // edit: prefill
        : { asset_tag: '', name: '', category: '', status: 'Available', serial_number: '', purchase_date: '', cost: '' } // add: empty form
    showOffcanvas.value = true
}

// Close Offcanvas
const closeOffcanvas = () => {
    showOffcanvas.value = false
}

// Submit Add/Edit asset
const submitAsset = () => {
    if (mode.value === 'add') {
        // console.log("added", form.value); 
        assets.value.push({ ...form.value })
    } else {
        // console.log("updated", form.value); 
        Object.assign(selectedAsset.value, form.value)
    }
    closeOffcanvas()
}

// Delete asset
const deleteAsset = async (asset) => {
    const ok = await confirm({
        title: 'Delete Asset',
        message: `Are you sure you want to delete ${asset.name} (${asset.asset_tag})?`,
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })
    if (ok) {
        assets.value = assets.value.filter(a => a !== asset)
    }
}

// Export assets
const exportAssets = () => {
    console.log('Exporting assets...')
    // Implementation for export functionality
}
</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Assets</h1>
        </div>

        <div class="flex justify-end w-fit ml-auto space-x-3 my-5">
            <button @click="exportAssets"
                class="bg-slate-600 hover:bg-slate-700 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all">
                Export
            </button>
            <button @click="openOffcanvas('add')"
                class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all ml-auto block">
                Add Asset
            </button>
        </div>

        <!-- Single Offcanvas for Add/Edit -->
        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">
                    {{ mode === 'add' ? 'Add New Asset' : 'Edit Asset' }}
                </h2>

                <div class="space-y-4">
                    <FormInput type="text" label="Asset Tag" placeholder="e.g. AST-001" v-model="form.asset_tag"
                        required />
                    <FormInput type="text" label="Name" placeholder="Asset Name" v-model="form.name" required />
                    <FormInput type="select" label="Category" placeholder="Select Category" v-model="form.category"
                        :options="['Laptop', 'Monitor', 'Peripherals', 'Furniture', 'Vehicle']" required />
                    <FormInput type="select" label="Status" placeholder="Select Status" v-model="form.status"
                        :options="['Available', 'In Use', 'Defective', 'Maintenance', 'Dispose']" required />
                    <FormInput type="text" label="Serial Number" placeholder="Serial Number"
                        v-model="form.serial_number" />
                    <FormInput type="date" label="Purchase Date" v-model="form.purchase_date" />
                    <FormInput type="number" step="0.01" label="Cost" placeholder="0.00" v-model="form.cost" />
                </div>

                <div class="w-full mt-8">
                    <FormInput type="button" :label="mode === 'add' ? 'Add Asset' : 'Update Asset'"
                        @click="submitAsset" />
                </div>
            </div>
        </Offcanvas>

        <!-- Main Table -->
        <Table :columns="columns" :data="assets" :total-row-count="assets.length" />
    </div>
</template>

<style lang="css" scoped></style>