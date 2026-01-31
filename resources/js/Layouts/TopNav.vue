<script setup>
import HamburgerIcon from '@/Components/Icons/HamburgerIcon.vue'
import { User, Bell } from 'lucide-vue-next'
import { ref, onMounted, onUnmounted } from 'vue';
const emit = defineEmits(['toggle']);

const containerRef = ref(null);
const isOpen = ref(false);

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
}

const handleClickOutside = (event) => {
    if (containerRef.value && !containerRef.value.contains(event.target)) {
        isOpen.value = false;
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
})

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
})
</script>
jewc
<template>
    <div class="bg-blue-950 w-full flex justify-between items-center p-5">
        <button @click="emit('toggle')" class="cursor-pointer">
            <HamburgerIcon class="text-white" />
        </button>
        <div class="flex items-center gap-5" ref="containerRef">
            <div class="relative">
                <Bell class="text-white cursor-pointer" @click="toggleDropdown" />
                <div class="absolute right-0 top-16 min-w-64 rounded-lg outline shadow-lg"
                    :class="isOpen ? 'block' : 'hidden'">
                    <p class="p-2 text-lg font-bold">Notifications</p>
                    <ul>
                        <li class="p-2 shadow-sm">You have a new notification</li>
                        <li class="p-2 shadow-sm">You have a new notification</li>
                        <li class="p-2 shadow-sm">You have a new notification</li>
                        <li class="p-2 shadow-sm">You have a new notification</li>
                        <li class="p-2 shadow-sm">You have a new notification</li>
                    </ul>
                </div>
            </div>
            <Link :href="route('profile')">
            <User class="text-white cursor-pointer outline rounded-full" />
            </Link>
        </div>
    </div>
</template>

<style lang="scss" scoped></style>