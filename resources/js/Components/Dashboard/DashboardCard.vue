<template>
    <button
        class="w-52 p-5 rounded-lg shadow-lg hover:transform hover:scale-105 transition-all duration-300 ease-in-out bg-white cursor-pointer active:bg-slate-600"
        active
    >
        <div class="flex items-center justify-between">
            <h1 class="text-md font-semibold">{{ cardTitle }}</h1>
            <fa :icon="faIcon" :size="faSize" />
        </div>
        <p class="text-end mt-10 text-xl">{{ totalItem }}</p>
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
