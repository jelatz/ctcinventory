<script setup>
import Offcanvas from '@/Components/Offcanvas.vue'
import { ref, h } from 'vue';
import Table from '@/Components/Table.vue';
import { SquarePen, Trash2 } from 'lucide-vue-next';
import Modal from '@/Components/Modal.vue';
import { useConfirm } from '@/composables/useConfirm'
import FormInput from '@/Components/FormInput.vue'

const confirm = useConfirm();
const modelValue = ref(false)

const showOffcanvas = ref(false);
const mode = ref['add', 'edit']
const selectedUser = ref(null);

const columns = [
    {
        accessorKey: 'name',
        header: 'Name',
    },
    {
        accessorKey: 'email',
        header: 'Email',
    },
    {
        accessorKey: 'role',
        header: 'Role',
    },
    {
        id: 'actions',
        header: 'Actions',
        cell: ({ row }) => {
            return h('div', { class: 'flex gap-3' }, [
                h(SquarePen, {
                    class: 'w-5 h-5 cursor-pointer text-blue-600 hover:text-blue-800',
                    onClick: () => editUser(row.original),
                }),
                h(Trash2, {
                    class: 'w-5 h-5 cursor-pointer text-red-600 hover:text-red-800',
                    onClick: () => deleteUser(row.original),
                }),
            ])
        },
    },
]

const users = ref([
    {
        name: 'John Doe',
        email: 'john@example.com',
        role: 'Admin',
    },
    {
        name: 'Jane Smith',
        email: 'jane@example.com',
        role: 'User',
    },
])

const deleteUser = async () => {
    const ok = await confirm({
        title: 'Delete User',
        message: 'Are you sure you want to delete this user?',
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })

    if (ok) {
        console.log('User deleted')
    }
}

</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Users</h1>
        </div>
        <button @click="showOffcanvas = true"
            class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all my-10 ml-auto block">
            Add User
        </button>

        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">Add New User</h2>
                <!-- Form content would go here -->
                <FormInput type="text" label="Name" placeholder="Enter your name" required />
                <FormInput type="email" label="Email" placeholder="Enter your email" required />
                <FormInput type="password" label="Password" placeholder="Enter your password" required />
                <FormInput type="select" label="Role" placeholder="Select your role" :options="['Admin', 'User']"
                    required />
                <div class="w-96 mx-auto mt-10">
                    <FormInput type="button" label="Add" />
                </div>
            </div>
        </Offcanvas>

        <Modal v-model="modelValue" />
        <!-- Main Table -->
        <Table :columns="columns" :data="users" :total-row-count="users.length" />
    </div>
</template>

<style lang="css" scoped></style>