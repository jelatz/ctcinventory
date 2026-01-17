<template>
    <div class="fixed top-5 right-5 space-y-3 z-50 w-96">
        <div v-for="toast in toasts" :key="toast.id" class="px-4 py-3 rounded-lg text-white shadow-lg relative"
            :class="toast.type === 'success' ? 'bg-green-600' : 'bg-red-600'">
            {{ toast.message }}
            <button @click="removeToast(toast.id)" class="absolute top-2 right-2 text-white">X</button>
        </div>
    </div>
</template>

<script setup>
import { useToast } from '@/composables/useToast'
const { toasts } = useToast()

const removeToast = (id) => {
    toasts.value = toasts.value.filter((toast) => toast.id !== id)
}
</script>
