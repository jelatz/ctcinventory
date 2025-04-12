<template>
    <div
        class="w-full shadow-lg px-5 py-[1rem] flex justify-between items-center"
    >
        <button type="button" class="cursor-pointer" @click="toggleSidenav">
            <fa icon="fa-solid fa-bars" size="lg" />
        </button>
        <div class="flex justify-center items-center space-x-2 relative">
            <img src="" alt="profile picture" class="rounded-full w-5 h-5" />
            <p>Cher</p>
            <button
                type="button"
                class="cursor-pointer"
                @click="toggleDropdown"
            >
                <fa icon="fa-solid fa-caret-down" size="lg" />
            </button>
            <!-- Dropdown -->
            <Dropdown
                :isShow="isShow"
                class="absolute -bottom-[5rem] w-44 right-1 border shadow-lg rounded-lg bg-slate-100"
            >
                <Link
                    :href="route('profile')"
                    class="w-full block py-1 px-5 hover:bg-slate-300"
                    >Account Settings</Link
                >
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="block w-full py-1 px-5 hover:bg-slate-300 cursor-pointer"
                >
                    Logout
                </Link>
            </Dropdown>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
const emit = defineEmits(["toggleSidenav"]);

const toggleSidenav = () => {
    emit("toggleSidenav");
};

const isShow = ref(false);
const toggleDropdown = () => {
    isShow.value = !isShow.value;
};

// Close dropdown when clicking outside
const closeDropdown = () => {
    isShow.value = false;
};

const handleClickOutside = (event) => {
    // Check if click is outside the dropdown
    const target = event.target;
    const dropdownButton = document.querySelector("[data-dropdown-toggle]");

    if (
        isShow.value &&
        !target.closest(".relative") &&
        target !== dropdownButton
    ) {
        closeDropdown();
    }
};

onMounted(() => {
    document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

// Expose closeDropdown method for parent components
defineExpose({ closeDropdown });
</script>

<style scoped></style>
