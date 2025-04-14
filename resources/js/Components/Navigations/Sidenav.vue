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
            <Link
                :href="route('dashboard')"
                class="relative hover:bg-[#e3e2e2] hover:transition-[background-color 0.4s] hover:text-[#162556] w-full text-left py-3 pl-16"
            >
                <span class="absolute left-3">{{ faDashboard }}</span>
                Dashboard
            </Link>
            <NavButton
                buttonValue="Users"
                faIcon="U"
                buttonID="users"
                @click="toggleUsersOptions"
            />
            <NavButton
                buttonValue="Categories"
                faIcon="C"
                @click="toggleCategoriesOptions"
            />
            <NavButton
                buttonValue="Items"
                faIcon="I"
                @click="toggleItemsOptions"
            />
            <NavButton
                buttonValue="Transactions"
                faIcon="T"
                @click="toggleTransactionsOptions"
            />
            <Dropdown :isShow="isShow" />
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import NavButton from "@/Components/Navigations/NavButton.vue";
import Dropdown from "@/Components/Navigations/Dropdown.vue";
defineProps({
    isShown: Boolean,
});

const faDashboard = ref("D");
const isShow = ref(false);
const toggleUsersOptions = () => {
    isShow.value = !isShow.value;
    $("#users").val("yes");
};
</script>

<style scoped></style>
