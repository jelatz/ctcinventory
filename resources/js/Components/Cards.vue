<script setup>
const props = defineProps({
    title: String,
    value: String,
    icon: String,
})
</script>

<template>
    <div class="min-w-96 rounded-lg shadow-lg p-5 outline">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold">{{ title }}</h1>
                <p class="text-gray-500 text-xl mt-10">{{ value }}</p>
            </div>
            <component :is="icon" class="w-10 h-10" />
        </div>
    </div>
</template>

<style lang="scss" scoped></style>