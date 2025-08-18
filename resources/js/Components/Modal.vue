<template>
    <div v-if="isOpen" class="absolute inset-0 z-50 flex items-center justify-center bg-black/50"
        @click.self="emit('close')">
        <div :class="['bg-white rounded-xl shadow-lg relative', modalSize]">
            <div class="border-b-1 w-full p-5">
                <h2 class="text-xl font-semibold">{{ modalTitle }}</h2>
            </div>
            <button class="absolute top-5 right-4 text-2xl text-gray-500 hover:text-red-500" @click="emit('close')">
                &times;
            </button>
            <slot />
        </div>
    </div>
</template>

<script setup>
defineProps({
    isOpen: Boolean,
    modalSize: String,
    modalTitle: String,
});
const emit = defineEmits(["close"]);
</script>
