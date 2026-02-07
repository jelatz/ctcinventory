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
const mode = ref('add')
const selectedCategory = ref(null)

// Categories table data
const categories = ref([
    { name: 'Laptop', status: 'Active' },
    { name: 'Monitor', status: 'Active' },
    { name: 'Peripherals', status: 'Active' },
    { name: 'Furniture', status: 'Inactive' },
])

// Form state
const form = ref({
    name: '',
    status: 'Active'
})

// Table columns
const columns = [
    { accessorKey: 'name', header: 'Name' },
    {
        accessorKey: 'status',
        header: 'Status',
        cell: ({ row }) => {
            const status = row.original.status
            const colors = {
                'Active': 'bg-green-100 text-green-800',
                'Inactive': 'bg-gray-100 text-gray-800'
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
                    onClick: () => deleteCategory(row.original)
                })
            ])
        }
    }
]

// Open Offcanvas for Add or Edit
const openOffcanvas = (action, category = null) => {
    mode.value = action
    selectedCategory.value = category
    form.value = category
        ? { ...category } // edit: prefill
        : { name: '', status: 'Active' } // add: empty form
    showOffcanvas.value = true
}

// Close Offcanvas
const closeOffcanvas = () => {
    showOffcanvas.value = false
}

// Submit Add/Edit category
const submitCategory = () => {
    if (mode.value === 'add') {
        categories.value.push({ ...form.value })
    } else {
        Object.assign(selectedCategory.value, form.value)
    }
    closeOffcanvas()
}

// Delete category
const deleteCategory = async (category) => {
    const ok = await confirm({
        title: 'Delete Category',
        message: `Are you sure you want to delete ${category.name}?`,
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })
    if (ok) {
        categories.value = categories.value.filter(c => c !== category)
    }
}
</script>

<template>
    <div class="p-16 mx-auto">
        <div class="flex items-center justify-between mb-8">
            <h1 class="font-bold text-3xl text-slate-800">Categories</h1>
        </div>

        <button @click="openOffcanvas('add')"
            class="bg-blue-950 hover:bg-amber-600 text-white px-6 py-2.5 rounded-lg shadow-sm font-medium transition-all my-10 ml-auto block">
            Add Category
        </button>

        <!-- Single Offcanvas for Add/Edit -->
        <Offcanvas v-model="showOffcanvas">
            <div class="mt-2">
                <h2 class="text-2xl font-bold text-slate-800 mb-6 border-b pb-4">
                    {{ mode === 'add' ? 'Add New Category' : 'Edit Category' }}
                </h2>

                <div class="space-y-4">
                    <FormInput type="text" label="Name" placeholder="Category Name" v-model="form.name" required />
                    <FormInput type="select" label="Status" placeholder="Select Status" v-model="form.status"
                        :options="['Active', 'Inactive']" required />
                </div>

                <div class="w-full mt-8">
                    <FormInput type="button" :label="mode === 'add' ? 'Add Category' : 'Update Category'"
                        @click="submitCategory" />
                </div>
            </div>
        </Offcanvas>

        <!-- Main Table -->
        <Table :columns="columns" :data="categories" :total-row-count="categories.length" />
    </div>
</template>

<style lang="css" scoped></style>