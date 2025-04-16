<template>
    <div class="flex min-h-screen">
        <Sidenav
            :isShown="isShown"
            @close-dropdown="topnavRef?.closeDropdown()"
        />

        <main class="w-full">
            <Topnav ref="topnavRef" @toggleSidenav="toggleSidenav" />
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from "vue";
import Sidenav from "@/Components/Navigations/Sidenav.vue";
import Topnav from "@/Components/Navigations/Topnav.vue";

const isShown = ref(true);
const topnavRef = ref(null);

const toggleSidenav = () => {
    isShown.value = !isShown.value;
};
</script>

<style scoped></style>
