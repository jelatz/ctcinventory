<script setup>
import { ref } from 'vue'
import Table from '@/Components/Table.vue'

// Users table data
const users = ref([
    { name: 'John Doe', email: 'john@example.com', role: 'Employee' },
    { name: 'Jane Smith', email: 'jane@example.com', role: 'Employee' }
])


// Table columns
const columns = [
    { accessorKey: 'name', header: 'Name' },
    { accessorKey: 'email', header: 'Email' },
    { accessorKey: 'role', header: 'Role' },
]


</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Employees</h1>
        </div>

        <!-- Main Table -->
        <Table :columns="columns" :data="users" :total-row-count="users.length" />
    </div>
</template>
