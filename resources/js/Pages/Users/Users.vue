<script setup>
import Offcanvas from '@/Components/Offcanvas.vue'
import { ref, h, onMounted, onUnmounted } from 'vue'
import Table from '@/Components/Table.vue'
import { SquarePen, Trash2 } from 'lucide-vue-next'
import { useConfirm } from '@/composables/useConfirm'
import FormInput from '@/Components/FormInput.vue'

const confirm = useConfirm()

// Offcanvas state
const showOffcanvas = ref(false)
const mode = ref('add') // 'add' or 'edit'
const selectedUser = ref(null)

// Users table data
const users = ref([
    { name: 'John Doe', email: 'john@example.com', role: 'Admin' },
    { name: 'Jane Smith', email: 'jane@example.com', role: 'User' }
])

// Form state
const form = ref({
    name: '',
    email: '',
    password: '',
    role: ''
})

// Table columns
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

// Open Offcanvas for Add or Edit
const openOffcanvas = (action, user = null) => {
    mode.value = action
    selectedUser.value = user
    form.value = user
        ? { ...user, password: '' } // edit: prefill except password
        : { name: '', email: '', password: '', role: '' } // add: empty form
    showOffcanvas.value = true
}

// Close Offcanvas
const closeOffcanvas = () => {
    showOffcanvas.value = false
}

// Submit Add/Edit user
const submitUser = () => {
    if (mode.value === 'add') {
        console.log("added"); return;
        users.value.push({ ...form.value })
    } else {
        console.log("updated"); return;
        Object.assign(selectedUser.value, form.value)
    }
    closeOffcanvas()
}

// Delete user
const deleteUser = async (user) => {
    const ok = await confirm({
        title: 'Delete User',
        message: 'Are you sure you want to delete this user?',
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })
    if (ok) {
        console.log("deleted"); return;
        users.value = users.value.filter(u => u !== user)
    }
}

const handleKeyPress = (e) => {
    if (e.key === 'Escape') {
        closeOffcanvas()
    }
}

onMounted(() => {
    document.addEventListener('keydown', handleKeyPress)
})

onUnmounted(() => {
    document.removeEventListener('keydown', handleKeyPress)
})

</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Users</h1>
        </div>

        <button @click="openOffcanvas('add')"
            class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all my-10 ml-auto block">
            Add User
        </button>

        <!-- Single Offcanvas for Add/Edit -->
        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">
                    {{ mode === 'add' ? 'Add New User' : 'Edit User' }}
                </h2>

                <FormInput type="text" label="Name" placeholder="Enter name" v-model="form.name" required />
                <FormInput type="email" label="Email" placeholder="Enter email" v-model="form.email" required />
                <FormInput type="password" label="Password" placeholder="Enter password" v-model="form.password"
                    :required="mode === 'add'" />
                <FormInput type="select" label="Role" placeholder="Select role" v-model="form.role"
                    :options="['Admin', 'User']" required />

                <div class="w-96 mx-auto mt-10">
                    <FormInput type="button" :label="mode === 'add' ? 'Add' : 'Update'" @click="submitUser" />
                </div>
            </div>
        </Offcanvas>

        <!-- Main Table -->
        <Table :columns="columns" :data="users" :total-row-count="users.length" />
    </div>
</template>
