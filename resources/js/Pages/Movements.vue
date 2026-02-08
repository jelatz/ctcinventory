<script setup>
import FormInput from '@/Components/FormInput.vue'
import Table from '@/Components/Table.vue'
import { ref, h } from 'vue'
import { SquarePen, Trash2 } from 'lucide-vue-next'
import { useOffcanvasForm } from '@/Composables/offCanvas.js'
import Offcanvas from '@/Components/Offcanvas.vue'
import { useConfirm } from '@/Composables/useConfirm'
const confirm = useConfirm()


const columns = [
    { accessorKey: 'date', header: 'Date' },
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
                    onClick: () => deleteMovement(row.original)
                })
            ])
        }
    }
]

const movements = ref([
    { date: '2023-01-15', asset: 'AST-001', movementType: 'Transfer', from: 'Room 101', to: 'Room 102', assignedTo: 'John Doe', status: 'Available' },
    { date: '2023-02-10', asset: 'AST-002', movementType: 'Transfer', from: 'Room 102', to: 'Room 101', assignedTo: 'Jane Smith', status: 'In Use' }
])


const {
    showOffcanvas,
    mode,
    form,
    openOffcanvas,
    applyChanges,
    deleteRow
} = useOffcanvasForm({
    date: '',
    asset: '',
    movementType: '',
    from: '',
    to: '',
    assignedTo: '',
    status: 'Available'
})

// Delete Movement

const deleteMovement = async (movement) => {
    const ok = await confirm({
        title: 'Delete Movement',
        message: `Are you sure you want to delete movement for asset ${movement.asset} on ${movement.date}?`,
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })

    if (ok) {
        movements.value = movements.value.filter(m => m !== movement)
    }
}

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
            <button @click="openOffcanvas('add')" class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all
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
        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">
                    {{ mode === 'add' ? 'Add New Movement' : 'Edit Movement' }}
                </h2>

                <div class="space-y-4">
                    <FormInput type="date" label="Date" placeholder="Search" v-model="form.date" />
                    <FormInput type="select" label="Asset" placeholder="Search" v-model="form.asset" />
                    <FormInput type="select" label="Type" placeholder="Search" v-model="form.movementType" />
                    <FormInput type="select" label="Status" placeholder="Search" v-model="form.status" />
                </div>

                <div class="w-full mt-8">
                    <FormInput type="button" :label="mode === 'add' ? 'Add Movement' : 'Update Movement'"
                        @click="applyChanges(movements)" />
                </div>
            </div>
        </Offcanvas>

        <!-- Mail Table -->
        <Table :columns="columns" :data="movements" :total-row-count="movements.length" />

    </div>
</template>

<style lang="css" scoped></style>