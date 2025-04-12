<!-- Sidenav.vue -->
<template>
    <div
        class="bg-blue-950 text-white sidenav overflow-hidden transition-all duration-600 ease-in-out"
        :class="isShown ? 'w-96' : 'w-0'"
    >
        <!-- Logo and company name -->
        <div
            class="flex justify-center flex-col p-5 items-center w-inherit text-nowrap"
        >
            <img src="" alt="Calltek Logo" />
            <p class="mt-5 w-full text-center">Calltek Inc.</p>
        </div>
        <!-- Navigations -->
        <div
            class="flex flex-col justify-center items-center mt-5 navigations w-inherit text-nowrap"
        >
            <Link :href="route('dashboard')" class=""> Dashboard </Link>
            <button type="button" class="cursor-pointer">Users</button>
            <button type="button" class="cursor-pointer">Categories</button>
            <button type="button" class="cursor-pointer">Items</button>
            <button type="button" class="cursor-pointer">Transactions</button>
        </div>
    </div>
</template>

<script setup>
defineProps({
    isShown: Boolean,
});
</script>

<style scoped>
.navigations a:hover,
.navigations button:hover {
    background-color: #e3e2e2;
    transition: background-color 0.4s;
    color: #162556;
}
.navigations button,
.navigations a {
    width: 100%;
    text-align: left;
    padding: 1rem 0 1rem 1rem;
}
</style>
