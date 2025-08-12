<template>
    <button
        class="p-5 flex-1 rounded-lg shadow-lg hover:transform hover:scale-105 transition-all duration-300 ease-in-out bg-white cursor-pointer active:bg-slate-600"
        @click="$emit('card-click')">
        <div class="flex items-start space-y-5 flex-col justify-between">
            <h1 class="text-md font-semibold">{{ cardTitle }}</h1>
            <div class="flex items-center justify-between w-full">
                <fa :icon="faIcon" :size="faSize" />
                <p class="text-end text-xl">{{ totalItem }}</p>
            </div>
        </div>
    </button>
</template>

<script setup>
defineProps({
    totalItem: Number,
    cardTitle: String,
    faIcon: Array,
    faSize: String,
});
</script>

<style scoped></style>
