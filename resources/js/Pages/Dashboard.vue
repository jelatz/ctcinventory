<script setup>
import { onMounted } from 'vue'
import { useToast } from '@/Composables/useToast'
import Cards from '@/Components/Cards.vue'
import { Home, Users, Boxes, Files, ArrowLeftRight } from 'lucide-vue-next'

import Toast from '@/Components/Toast.vue'
const { add } = useToast()

const cards = [
    {
        id: 1,
        title: 'Total Assets',
        value: '100',
        icon: Boxes,
    },
    {
        id: 2,
        title: 'Total Users',
        value: '100',
        icon: Users,
    },
    {
        id: 3,
        title: 'Total Movement',
        value: '100',
        icon: ArrowLeftRight,
    },
    {
        id: 4,
        title: 'Total Reports',
        value: '100',
        icon: Files,
    },
]

onMounted(() => {
    add('Saved successfully')
})
</script>

<template>
    <div class="p-10">
        <!-- <Toast /> -->
        <h1 class="text-2xl font-bold">Dashboard</h1>

        <div class="grid grid-cols-4 gap-10 mt-5">
            <Cards v-for="card in cards" :key="card.id" :title="card.title" :value="card.value" :icon="card.icon" />
        </div>
    </div>
</template>

<style scoped></style>