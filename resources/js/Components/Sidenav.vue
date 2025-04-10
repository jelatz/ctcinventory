<!-- Sidenav.vue -->
<template>
    <div
        class="bg-blue-950 text-white sidenav overflow-hidden transition-all duration-600 ease-in-out"
        :class="isShown ? 'w-96' : 'w-0'"
    >
        <div class="flex justify-center flex-col p-5 items-center w-full">
            <img src="" alt="Calltek Logo" />
            <p class="mt-5">Calltek Inc.</p>
        </div>
        <!-- Navigations -->
        <div class="flex flex-col justify-center items-center mt-5 navigations">
            <Link
                :href="route('dashboard')"
                class="text-white hover:text-blue-500"
            >
                Dashboard
            </Link>
            <button type="button" class="cursor-pointer">Users</button>
            <button type="button" class="cursor-pointer">Categories</button>
            <button type="button" class="cursor-pointer">Items</button>
            <button type="button" class="cursor-pointer">Transactions</button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    isShown: Boolean, // Control the visibility of sidenav
});
</script>

<style scoped>
/* Sidenav styles */
</style>
