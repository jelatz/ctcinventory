<script setup>
import HamburgerIcon from '@/Components/Icons/HamburgerIcon.vue'
import { User, Bell } from 'lucide-vue-next'
const emit = defineEmits(['toggle']);
</script>

<template>
    <div class="bg-blue-950 w-full flex justify-between items-center p-5">
        <button @click="emit('toggle')" class="cursor-pointer">
            <HamburgerIcon class="text-white" />
        </button>
        <div class="flex items-center gap-5">
            <Bell class="text-white cursor-pointer" />
            <Link href="/profile">
            <User class="text-white cursor-pointer outline rounded-full" />
            </Link>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>