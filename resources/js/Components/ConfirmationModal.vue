<script setup>
import { ref } from 'vue'

const props = defineProps({
    title: String,
    message: String,
    confirmText: {
        type: String,
        default: 'Confirm'
    },
    cancelText: {
        type: String,
        default: 'Cancel'
    }
})

const emit = defineEmits(['confirm', 'cancel'])
</script>

<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" @click="emit('cancel')"></div>

        <!-- Modal -->
        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10 animate-scaleIn">
            <h2 class="text-xl font-bold text-slate-800 mb-2">
                {{ title }}
            </h2>

            <p class="text-slate-600 mb-6">
                {{ message }}
            </p>

            <div class="flex justify-end gap-3">
                <button @click="emit('cancel')" class="px-4 py-2 rounded-lg bg-slate-200 hover:bg-slate-300 transition">
                    {{ cancelText }}
                </button>

                <button @click="emit('confirm')"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                    {{ confirmText }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(.95);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-scaleIn {
    animation: scaleIn .15s ease-out;
}
</style>
