<script setup>
import FormInput from '@/Components/FormInput.vue'
import Table from '@/Components/Table.vue'
import { ref, h } from 'vue'
import { SquarePen, Trash2 } from 'lucide-vue-next'


const columns = [
    { accessorKey: 'datetime', header: 'Date/Time' },
    { accessorKey: 'asset', header: 'Asset' },
    { accessorKey: 'movementType', header: 'Movement Type' },
    { accessorKey: 'from', header: 'From' },
    { accessorKey: 'to', header: 'To' },
    { accessorKey: 'assignedTo', header: 'Assigned To' },
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

const movements = ref([
    { datetime: '2023-01-15', asset: 'AST-001', movementType: 'Transfer', from: 'Room 101', to: 'Room 102', assignedTo: 'John Doe', status: 'Available' },
    { datetime: '2023-02-10', asset: 'AST-002', movementType: 'Transfer', from: 'Room 102', to: 'Room 101', assignedTo: 'Jane Smith', status: 'In Use' }
])
</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Movements</h1>
        </div>

        <div class="flex justify-end w-fit ml-auto space-x-5">
            <button class="bg-gray-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all
            my-10 ml-auto block">
                Export
            </button>
            <button class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all
        my-10 ml-auto block">
                New Movement
            </button>
        </div>

        <!-- Filters -->
        <div class="my-5 grid grid-cols-5 gap-x-5">
            <FormInput type="date" label="From" placeholder="Search" />
            <FormInput type="date" label="To" placeholder="Search" />
            <FormInput type="select" label="Asset" placeholder="Search" />
            <FormInput type="select" label="Type" placeholder="Search" />
            <FormInput type="select" label="Status" placeholder="Search" />
        </div>

        <!-- Mail Table -->
        <Table :columns="columns" :data="movements" :total-row-count="movements.length" />

    </div>
</template>

<style lang="css" scoped></style>