<template>
    <div>
        <!-- Wrap everything in a single root element -->
        <div class="w-full shadow-lg px-3 py-2">
            <button type="button" class="cursor-pointer" @click="toggle">
                <fa icon="fa-solid fa-bars" size="lg" />
            </button>
        </div>

        <Link
            :href="route('logout')"
            method="post"
            as="button"
            class="text-black mt-10"
        >
            Logout
        </Link>
    </div>
</template>

<script setup>
import { defineEmits } from "vue";
const emit = defineEmits(["toggleSidenav"]);

const toggle = () => {
    emit("toggleSidenav");
};
</script>
