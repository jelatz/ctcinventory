<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
        @click.self="emit('close')"
    >
        <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
            <button
                class="absolute top-2 right-3 text-2xl text-gray-500 hover:text-red-500"
                @click="emit('close')"
            >
                &times;
            </button>
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    isOpen: Boolean,
});
const emit = defineEmits(["close"]);
</script>
