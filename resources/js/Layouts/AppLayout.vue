<!-- AppLayout.vue -->
<template>
    <div class="flex min-h-screen">
        <!-- Pass the toggleSidenav method to the slot -->
        <Sidenav :isShown="isShown" />
        <div class="w-full">
            <!-- Use the scoped slot to pass toggleSidenav method -->
            <slot :toggleSidenav="toggleSidenav" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Sidenav from "@/Components/Sidenav.vue";

const isShown = ref(true);

// Method to toggle sidenav visibility
const toggleSidenav = () => {
    isShown.value = !isShown.value;
    console.log("Sidenav toggled:", isShown.value); // Just for logging
};
</script>

<style scoped>
/* Your styles */
</style>
