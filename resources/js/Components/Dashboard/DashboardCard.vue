<template>
    <button
        class="p-5 rounded-lg shadow-lg hover:transform hover:scale-105 transition-all duration-300 ease-in-out bg-white cursor-pointer active:bg-slate-600"
        @click="$emit('card-click')">
        <div class="flex items-start space-y-5 flex-col justify-between">
            <h1 class="text-md font-semibold">{{ cardTitle }}</h1>
            <div class="flex items-center justify-between w-full">
                <div class="text-left">
                    <fa :icon="faIcon" :size="faSize" />
                </div>
                <p class="text-xl text-right">{{ totalItem }}</p>
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
    faClass: String,
});
</script>

<style scoped></style>
