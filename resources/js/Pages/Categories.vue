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
const selectedAsset = ref(null)

const categories = ref([
    { category_name: 'Laptop' },
    { category_name: 'Monitor' }
])

// Form state
const form = ref({
    category: '',
})

// Table columns
const columns = [
    { accessorKey: 'category_name', header: 'Category Name' },
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
    selectedAsset.value = category
    form.value = category
        ? { ...category } // edit: prefill
        : { category: '' } // add: empty form
    showOffcanvas.value = true
}

// Close Offcanvas
const closeOffcanvas = () => {
    showOffcanvas.value = false
}

// Submit Add/Edit asset
const submitCategory = () => {
    if (mode.value === 'add') {
        // console.log("added", form.value); 
        categories.value.push({ ...form.value })
    } else {
        // console.log("updated", form.value); 
        Object.assign(selectedAsset.value, form.value)
    }
    closeOffcanvas()
}

// Delete asset
const deleteCategory = async (category) => {
    const ok = await confirm({
        title: 'Delete Category',
        message: `Are you sure you want to delete ${category.category_name}?`,
        confirmText: 'Yes, Delete',
        cancelText: 'Cancel'
    })
    if (ok) {
        categories.value = categories.value.filter(a => a !== category)
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
                    {{ mode === 'add' ? 'Add New Category' : 'Edit Caregory' }}
                </h2>

                <div class="space-y-4">
                    <FormInput type="text" label="Category Name" placeholder="e.g. AST-001" v-model="form.category"
                        required />
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