<script setup>
import SideNav from '@/Layouts/SideNav.vue'
import TopNav from '@/Layouts/TopNav.vue'
import { ref } from 'vue'

const sidebarCollapsed = ref(false)

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 grid grid-cols-[auto_1fr]">
        <!-- v-model passes state DOWN -->
        <SideNav :collapsed="sidebarCollapsed" />

        <div>
            <!-- event comes UP -->
            <TopNav @toggle="toggleSidebar" />
            <slot />
        </div>
    </div>
</template>
