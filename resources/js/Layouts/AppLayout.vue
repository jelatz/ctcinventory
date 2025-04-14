<template>
    <div class="flex min-h-screen">
        <Sidenav :isShown="isShown" />
        <main class="w-full">
            <Topnav @toggleSidenav="toggleSidenav" />
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Sidenav from "@/Components/Navigations/Sidenav.vue";
import Topnav from "@/Components/Navigations/Topnav.vue";

const isShown = ref(true);

const toggleSidenav = () => {
    isShown.value = !isShown.value;
};
</script>

<style scoped></style>
