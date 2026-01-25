<script setup>
const props = defineProps({
    title: String,
    value: String,
    unassignedValue: String,
    inRepairValue: String,
    icon: String,
    totalValue: String,
})
</script>

<template>
    <div class="min-w-96 rounded-lg shadow-lg p-5 border border-amber-600">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-2xl font-bold">{{ title }}</h1>
            <component :is="icon" class="w-10 h-10" />
        </div>
        <div class="flex items-center justify-between **:text-xl **:font-bold **:text-gray-500">
            <p class="text-gray-500 text-xl font-bold">Total :</p>
            <p>{{ totalValue }}</p>
        </div>
        <div class="flex items-center justify-between **:text-xl **:font-bold **:text-gray-500">
            <p class="text-gray-500 text-xl font-bold">Assigned :</p>
            <p>{{ value }}</p>
        </div>
        <div v-if="unassignedValue" class="flex items-center justify-between **:text-xl **:font-bold **:text-gray-500">
            <p>Unassigned :</p>
            <p>{{ unassignedValue }}</p>
        </div>
        <div v-if="inRepairValue" class="flex items-center justify-between **:text-xl **:font-bold **:text-gray-500">
            <p>In Repair :</p>
            <p>{{ inRepairValue }}</p>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>