<script setup>
import FormInput from '@/Components/FormInput.vue'
import Table from '@/Components/Table.vue'
import { ref, h } from 'vue'
import { SquarePen, Trash2, Eye } from 'lucide-vue-next'
import { useOffcanvasForm } from '@/Composables/offCanvas.js'
import Offcanvas from '@/Components/Offcanvas.vue'
import { useConfirm } from '@/Composables/useConfirm'
const confirm = useConfirm()


const columns = [
    { accessorKey: 'date', header: 'Date' },
    { accessorKey: 'asset', header: 'Asset' },
    { accessorKey: 'assignmentType', header: 'Assignment Type' },
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
                    onClick: () => deleteAssignment(row.original)
                }),
                h(Eye, {
                    class: 'w-5 h-5 cursor-pointer text-blue-600 hover:text-blue-800',
                    onClick: () => viewAssignment(row.original)
                })
            ])
        }
    }
]

const viewAssignment = (assignment) => {
    openOffcanvas('view', assignment)
}

const assignments = ref([
    { date: '2023-01-15', asset: 'AST-001', assignmentType: 'Transfer', from: 'Room 101', to: 'Room 102', assignedTo: 'John Doe', status: 'Available' },
    { date: '2023-02-10', asset: 'AST-002', assignmentType: 'Transfer', from: 'Room 102', to: 'Room 101', assignedTo: 'Jane Smith', status: 'In Use' }
])


const {
    showOffcanvas,
    mode,
    form,
    openOffcanvas,
    applyChanges,
} = useOffcanvasForm({
    date: '',
    asset: '',
    assignmentType: '',
    from: '',
    to: '',
    assignedTo: '',
    status: 'Available',
    // Include the "Hidden" fields here
    description: '',
    condition: '',
    verifiedBy: '',
    serialNumber: ''
})

// Delete Movement

const deleteAssignment = async (assignment) => {
    const ok = await confirm({
        title: 'Delete Assignment',
        message: `Are you sure you want to delete assignment for asset ${assignment.asset} on ${assignment.date}?`,
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })

    if (ok) {
        assignments.value = assignments.value.filter(a => a !== assignment)
    }
}

</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Assignments</h1>
        </div>

        <div class="flex justify-end w-fit ml-auto space-x-5">
            <button class="bg-gray-500 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all
            my-10 ml-auto block">
                Export
            </button>
            <button @click="openOffcanvas('add')" class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all
        my-10 ml-auto block">
                New Assignment
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
                    {{ mode === 'add' ? 'Add' : mode === 'edit' ? 'Edit' : 'Full Details' }}
                </h2>

                <div class="grid grid-cols-1 gap-4">
                    <div class="grid grid-cols-2 gap-4">
                        <FormInput type="date" label="Date" v-model="form.date" :disabled="mode === 'view'" />
                        <FormInput type="text" label="Asset ID" v-model="form.asset" :disabled="mode === 'view'" />
                    </div>

                    <FormInput type="text" label="Serial Number" v-model="form.serialNumber"
                        :disabled="mode === 'view'" />

                    <div class="grid grid-cols-2 gap-4">
                        <FormInput type="text" label="From" v-model="form.from" :disabled="mode === 'view'" />
                        <FormInput type="text" label="To" v-model="form.to" :disabled="mode === 'view'" />
                    </div>

                    <div class="flex flex-col">
                        <label class="text-sm font-medium text-slate-700 mb-1">Movement Description</label>
                        <textarea v-model="form.description" :disabled="mode === 'view'"
                            class="border rounded-lg p-2 focus:ring-2 focus:ring-blue-500 disabled:bg-slate-50"
                            rows="3"></textarea>
                    </div>

                    <FormInput type="text" label="Verified By" v-model="form.verifiedBy" :disabled="mode === 'view'" />
                </div>

                <div class="mt-8">
                    <button v-if="mode === 'view'" @click="showOffcanvas = false"
                        class="w-full py-3 bg-slate-100 rounded-xl font-bold">
                        Close Details
                    </button>
                    <FormInput v-else type="button" :label="mode === 'add' ? 'Save' : 'Update'"
                        @click="applyChanges(movements)" />
                </div>
            </div>
        </Offcanvas>

        <!-- Mail Table -->
        <Table :columns="columns" :data="assignments" :total-row-count="assignments.length" />

    </div>
</template>

<style lang="css" scoped></style>