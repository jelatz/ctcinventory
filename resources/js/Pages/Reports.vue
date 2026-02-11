<script setup>
import FormInput from '@/Components/FormInput.vue'
import { ref, h } from 'vue'
import Table from '@/Components/Table.vue'
import { SquarePen, Trash2 } from 'lucide-vue-next'

const reportType = ref('')

const columns = [
    { accessorKey: 'name', header: 'Name' },
    { accessorKey: 'email', header: 'Email' },
    { accessorKey: 'role', header: 'Role' },
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
                    onClick: () => deleteUser(row.original)
                })
            ])
        }
    }
]

const users = ref([
    { name: 'John Doe', email: 'john@example.com', role: 'Admin' },
    { name: 'Jane Smith', email: 'jane@example.com', role: 'User' }
])
</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex itesm center mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Reports</h1>
        </div>

        <div class="my-10 flex items-center justify-between">
            <FormInput type="select" label="Report Type" placeholder="Select report type"
                :options="['Asset Report', 'User Report', 'Assignment Report']" class="w-96!" v-model="reportType" />
            <button @click="generateReport"
                class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all cursor-pointer">
                Generate Report
            </button>
        </div>

        <Table :columns="columns" :data="users" :total-row-count="users.length" />

    </div>
</template>

<style lang="css" scoped></style>