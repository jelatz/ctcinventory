<script setup>
import HamburgerIcon from '@/Components/Icons/HamburgerIcon.vue'
import { User } from 'lucide-vue-next'
const emit = defineEmits(['toggle']);
</script>

<template>
    <div class="bg-blue-950 w-full flex justify-between items-center p-5">
        <button @click="emit('toggle')" class="cursor-pointer">
            <HamburgerIcon class="text-white" />
        </button>
        <div>
            <User class="text-white" />
        </div>
    </div>
</template>

<style lang="scss" scoped></style>